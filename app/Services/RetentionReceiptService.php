<?php

namespace App\Services;

use App\SRI\Templates\XML\RetentionReceipt200;
use App\Utilities\Constants\ElectronicReceipstConstants;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class RetentionReceiptService
{
    public function generateTemplateXmlRetentionReceipt($request)
    {
        $retention_receipt_type = ElectronicReceipstConstants::RECEIPT_TYPE_RETENTION_RECEIPT;
        $electronicReceiptService = new ElectronicReceiptService();
        switch ($request->typeElectronicReceipt['version']) {
            case ElectronicReceipstConstants::RETENTION_RECEIPT_VERSION_200:
                $retentionReceiptData = new RetentionReceipt200();

                $retentionReceiptData->infoTributaria = $request->infoTributaria;
                $retentionReceiptData->infoTributaria['codDoc'] = $retention_receipt_type;
                $claveAcceso = $electronicReceiptService->getAccessKey(
                    $request->infoCompRetencion['fechaEmision'],
                    $request->infoTributaria['estab'] . $request->infoTributaria['ptoEmi'] . $request->infoTributaria['secuencial'],
                    $request->infoTributaria['ruc'],
                    $retention_receipt_type,
                    $request->infoTributaria['ambiente'],
                    $request->infoTributaria['tipoEmision']
                );

                $retentionReceiptData->infoTributaria['claveAcceso'] = $claveAcceso;
                $infoCompRetencion = $request->infoCompRetencion;
                $infoCompRetencion['fechaEmision'] = Carbon::parse($request->infoCompRetencion['fechaEmision'])->format('d/m/Y');

                $retentionReceiptData->infoCompRetencion = $infoCompRetencion;
                $retentionReceiptData->docsSustento = $request->docsSustento;
                $retentionReceiptData->infoAdicional = $request->infoAdicional;
                $retentionReceiptArray = $retentionReceiptData->comprobanteRetencion();

                $retentionReceiptXml = $electronicReceiptService->arrayToXml($retentionReceiptArray, 'comprobanteRetencion', ElectronicReceipstConstants::RETENTION_RECEIPT_VERSION_200);
                $signService = new SignService();
                $xmlSigned = $signService->signer($retentionReceiptXml);

                $response = $electronicReceiptService->sendElectronicReceiptToSriFromReception($xmlSigned, $request->infoTributaria['ambiente']);

                if ($response['estado'] == ElectronicReceiptService::responseSriTypeRecibida || $response['estado'] ==  ElectronicReceiptService::responseSriTypeEnProceso) {
                    $retentionReceiptSignedNumber = $request->infoTributaria['estab'] . '-' . $request->infoTributaria['ptoEmi'] . '-' . $request->infoTributaria['secuencial'];
                    $pathRetentionReceipt = ElectronicReceiptService::partialPathElecetronicReceipt . '/retention_receipt';
                    if (!Storage::exists('public/retention_receipt'))
                        Storage::makeDirectory('public/retention_receipt');
                    $pathSaveXmlSigned = storage_path($pathRetentionReceipt . '/' . $retentionReceiptSignedNumber . '.xml');
                    file_put_contents($pathSaveXmlSigned, $xmlSigned);

                    $response = $electronicReceiptService->sendElectronicReceiptToSriFromAuthorization($claveAcceso, $request->infoTributaria['ambiente']);
                }

                $verifyResponse = $electronicReceiptService->verifyResponse($response);

                $status = $verifyResponse['status'];

                if ($status == ElectronicReceiptService::responseSriTypeAutorizado || $status == ElectronicReceiptService::responseSriTypeEnProceso) {
                    $retentionReceiptsFolder = 'retention_receipt';
                    $notificationService = new NotificationService();
                    $jsonDataDecode = json_decode(json_encode($request->all()));

                    // $electronicReceipstConstants = new ElectronicReceipstConstants();
                    // foreach ($jsonDataDecode->infoFactura->pagos as $pago) {
                    //     $spanishPaymentMethodName = $electronicReceipstConstants->getSpanishPaymentMethods($pago->formaPago);
                    //     $pago->formaPago = $spanishPaymentMethodName;
                    // }

                    $notificationService->sendEmailNotificationElectronicReceiptCreated(
                        $jsonDataDecode,
                        ElectronicReceipstConstants::DEBIT_NOTE_SPANISH,
                        $request->infoCompRetencion['razonSocialSujetoRetenido'],
                        $request->infoTributaria['nombreComercial'],
                        $request->input('importeTotal'),
                        $retentionReceiptsFolder,
                        'retentionReceipt'
                    );
                    if (!array_key_exists('errors', $verifyResponse))
                        $verifyResponse['accessKey'] = $claveAcceso;
                    return $verifyResponse;
                } else {
                    if ($status == ElectronicReceiptService::responseSriTypeDevuelta || $status == ElectronicReceiptService::responseSriTypeNoAutorizado)
                        if (!array_key_exists('errors', $verifyResponse))
                            $verifyResponse['accessKey'] = $claveAcceso;
                    return $verifyResponse;
                }
                break;
        }
    }
}
