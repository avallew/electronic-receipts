<?php

namespace App\Services;

use App\SRI\Templates\XML\Invoice110;
use App\Utilities\Constants\ElectronicReceipstConstants;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class InvoiceService
{
    public function generateTemplateXmlInvoice($request)
    {
        $invoice_type = ElectronicReceipstConstants::RECEIPT_TYPE_INVOICE;
        $electronicReceiptService = new ElectronicReceiptService();
        switch ($request->typeElectronicReceipt['version']) {
            case ElectronicReceipstConstants::INVOICE_VERSION_110:
                $facturaData = new Invoice110();

                $facturaData->infoTributaria = $request->infoTributaria;
                $facturaData->infoTributaria['codDoc'] = $invoice_type;
                $claveAcceso = $electronicReceiptService->getAccessKey(
                    $request->infoFactura['fechaEmision'],
                    $request->infoTributaria['estab'] . $request->infoTributaria['ptoEmi'] . $request->infoTributaria['secuencial'],
                    $request->infoTributaria['ruc'],
                    $invoice_type,
                    $request->infoTributaria['ambiente'],
                    $request->infoTributaria['tipoEmision']
                );
                $facturaData->infoTributaria['claveAcceso'] = $claveAcceso;
                $request->merge([
                    'infoTributaria' => $facturaData->infoTributaria
                ]);

                $infoFactura = $request->infoFactura;
                $infoFactura['fechaEmision'] = Carbon::parse($request->infoFactura['fechaEmision'])->format('d/m/Y');

                $facturaData->infoFactura = $infoFactura;
                $facturaData->detalles = $request->detalles;
                if ($request->retenciones)
                    $facturaData->retenciones = $request->retenciones;
                $facturaData->infoAdicional = $request->infoAdicional;
                $facturaArray = $facturaData->factura();

                $invoiceXml = $electronicReceiptService->arrayToXml($facturaArray, 'factura', ElectronicReceipstConstants::INVOICE_VERSION_110);
                $signService = new SignService();
                $xmlSigned = $signService->signer($invoiceXml);

                $response = $electronicReceiptService->sendElectronicReceiptToSriFromReception($xmlSigned, $request->infoTributaria['ambiente']);

                if ($response['estado'] == ElectronicReceiptService::responseSriTypeRecibida || $response['estado'] ==  ElectronicReceiptService::responseSriTypeEnProceso) {
                    $invoiceSignedNumber = $request->infoTributaria['estab'] . '-' . $request->infoTributaria['ptoEmi'] . '-' . $request->infoTributaria['secuencial'];
                    $pathInvoices = ElectronicReceiptService::partialPathElecetronicReceipt . '/invoices';
                    if (!Storage::exists('public/invoices'))
                        Storage::makeDirectory('public/invoices');
                    $pathSaveXmlSigned = storage_path($pathInvoices . '/' . $invoiceSignedNumber . '.xml');
                    file_put_contents($pathSaveXmlSigned, $xmlSigned);

                    $response = $electronicReceiptService->sendElectronicReceiptToSriFromAuthorization($claveAcceso, $request->infoTributaria['ambiente']);
                }

                $verifyResponse = $electronicReceiptService->verifyResponse($response);

                $status = $verifyResponse['status'];

                if ($status == ElectronicReceiptService::responseSriTypeAutorizado || $status == ElectronicReceiptService::responseSriTypeNoAutorizado || $status == ElectronicReceiptService::responseSriTypeEnProceso) {
                    $invoicesFolder = 'invoices';
                    $notificationService = new NotificationService();
                    $jsonDataDecode = json_decode(json_encode($request->all()));

                    $electronicReceipstConstants = new ElectronicReceipstConstants();
                    foreach ($jsonDataDecode->infoFactura->pagos as $pago) {
                        $spanishPaymentMethodName = $electronicReceipstConstants->getSpanishPaymentMethods($pago->formaPago);
                        $pago->formaPago = $spanishPaymentMethodName;
                    }

                    $notificationService->sendEmailNotificationElectronicReceiptCreated(
                        $jsonDataDecode,
                        ElectronicReceipstConstants::INVOICE_SPANISH,
                        $request->infoFactura['razonSocialComprador'],
                        $request->infoTributaria['nombreComercial'],
                        $request->infoFactura['importeTotal'],
                        $invoicesFolder,
                        'invoice'
                    );
                    $dataToResponse['status'] = $verifyResponse['status'];
                    $dataToResponse['accessKey'] = $claveAcceso;
                    return $dataToResponse;
                } else {
                    if ($status == ElectronicReceiptService::responseSriTypeDevuelta)
                        $verifyResponse['accessKey'] = $claveAcceso;
                    return $verifyResponse;
                }
                break;
        }
    }
}
