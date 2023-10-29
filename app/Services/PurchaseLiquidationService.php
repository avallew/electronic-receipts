<?php

namespace App\Services;

use App\SRI\Templates\XML\PurchaseLiquidation110;
use App\Utilities\Constants\ElectronicReceipstConstants;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PurchaseLiquidationService
{
    public function generateTemplateXmlPurchaseLiquidation($request)
    {
        $purchase_liquidation_type = ElectronicReceipstConstants::RECEIPT_TYPE_PURCHASE_LIQUIDATION;
        $electronicReceiptService = new ElectronicReceiptService();
        switch ($request->typeElectronicReceipt['version']) {
            case ElectronicReceipstConstants::PURCHASE_LIQUIDATION_VERSION_110:
                $purchaseLiquidationData = new PurchaseLiquidation110();

                $purchaseLiquidationData->infoTributaria = $request->infoTributaria;
                $purchaseLiquidationData->infoTributaria['codDoc'] = $purchase_liquidation_type;
                $claveAcceso = $electronicReceiptService->getAccessKey(
                    $request->infoLiquidacionCompra['fechaEmision'],
                    $request->infoTributaria['estab'] . $request->infoTributaria['ptoEmi'] . $request->infoTributaria['secuencial'],
                    $request->infoTributaria['ruc'],
                    $purchase_liquidation_type,
                    $request->infoTributaria['ambiente'],
                    $request->infoTributaria['tipoEmision']
                );

                $purchaseLiquidationData->infoTributaria['claveAcceso'] = $claveAcceso;
                $infoLiquidacionCompra = $request->infoLiquidacionCompra;
                $infoLiquidacionCompra['fechaEmision'] = Carbon::parse($request->infoLiquidacionCompra['fechaEmision'])->format('d/m/Y');

                $purchaseLiquidationData->infoLiquidacionCompra = $infoLiquidacionCompra;
                $purchaseLiquidationData->detalles = $request->detalles;
                $purchaseLiquidationData->reembolsos = $request->reembolsos;
                $purchaseLiquidationData->maquinaFiscal = $request->maquinaFiscal;
                $purchaseLiquidationData->infoAdicional = $request->infoAdicional;
                $purchaseLiquidationArray = $purchaseLiquidationData->liquidacionCompra();

                $purchaseLiquidationXml = $electronicReceiptService->arrayToXml($purchaseLiquidationArray, 'liquidacionCompra', ElectronicReceipstConstants::PURCHASE_LIQUIDATION_VERSION_110);
                $signService = new SignService();
                $xmlSigned = $signService->signer($purchaseLiquidationXml);

                $response = $electronicReceiptService->sendElectronicReceiptToSriFromReception($xmlSigned, $request->infoTributaria['ambiente']);

                if ($response['estado'] == ElectronicReceiptService::responseSriTypeRecibida || $response['estado'] ==  ElectronicReceiptService::responseSriTypeEnProcesamiento) {
                    $purchaseLiquidationSignedNumber = $request->infoTributaria['estab'] . '-' . $request->infoTributaria['ptoEmi'] . '-' . $request->infoTributaria['secuencial'];
                    $pathPurchaseLiquidation = ElectronicReceiptService::partialPathElecetronicReceipt . '/purchase_liquidation';
                    if (!Storage::exists('public/purchase_liquidation'))
                        Storage::makeDirectory('public/purchase_liquidation');
                    $pathSaveXmlSigned = storage_path($pathPurchaseLiquidation . '/' . $purchaseLiquidationSignedNumber . '.xml');
                    file_put_contents($pathSaveXmlSigned, $xmlSigned);

                    $response = $electronicReceiptService->sendElectronicReceiptToSriFromAuthorization($claveAcceso, $request->infoTributaria['ambiente']);
                }

                $verifyResponse = $electronicReceiptService->verifyResponse($response);

                $status = $verifyResponse['status'];

                if ($status == ElectronicReceiptService::responseSriTypeAutorizado || $status == ElectronicReceiptService::responseSriTypeEnProcesamiento) {
                    $purchaseLiquidationsFolder = 'purchase_liquidation';
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
                        $request->infoLiquidacionCompra['razonSocialProveedor'],
                        $request->infoTributaria['nombreComercial'],
                        $request->infoLiquidacionCompra['importeTotal'],
                        $purchaseLiquidationsFolder,
                        'purchaseLiquidation'
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
