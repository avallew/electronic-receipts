<?php

namespace App\Services;

use App\SRI\Templates\XML\RemissionGuide110;
use App\Utilities\Constants\ElectronicReceipstConstants;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class RemissionGuideService
{
    public function generateTemplateXmlRemissionGuide($request)
    {
        $remission_guide_type = ElectronicReceipstConstants::RECEIPT_TYPE_REMISSION_GUIDE;
        $electronicReceiptService = new ElectronicReceiptService();
        switch ($request->typeElectronicReceipt['version']) {
            case ElectronicReceipstConstants::REMISSION_GUIDE_VERSION_110:
                $remissionGuideData = new RemissionGuide110();

                $remissionGuideData->infoTributaria = $request->infoTributaria;
                $remissionGuideData->infoTributaria['codDoc'] = $remission_guide_type;
                $claveAcceso = $electronicReceiptService->getAccessKey(
                    $request->infoGuiaRemision['fechaIniTransporte'],
                    $request->infoTributaria['estab'] . $request->infoTributaria['ptoEmi'] . $request->infoTributaria['secuencial'],
                    $request->infoTributaria['ruc'],
                    $remission_guide_type,
                    $request->infoTributaria['ambiente'],
                    $request->infoTributaria['tipoEmision']
                );

                $remissionGuideData->infoTributaria['claveAcceso'] = $claveAcceso;
                $infoGuiaRemision = $request->infoGuiaRemision;
                $infoGuiaRemision['fechaIniTransporte'] = Carbon::parse($request->infoGuiaRemision['fechaIniTransporte'])->format('d/m/Y');

                $remissionGuideData->infoGuiaRemision = $infoGuiaRemision;
                $remissionGuideData->destinatarios = $request->destinatarios;
                $remissionGuideData->infoAdicional = $request->infoAdicional;
                $remissionGuideArray = $remissionGuideData->remissionGuide();

                $remissionGuideXml = $electronicReceiptService->arrayToXml($remissionGuideArray, 'guiaRemision', ElectronicReceipstConstants::REMISSION_GUIDE_VERSION_110);
                $signService = new SignService();
                $xmlSigned = $signService->signer($remissionGuideXml);

                $response = $electronicReceiptService->sendElectronicReceiptToSriFromReception($xmlSigned, $request->infoTributaria['ambiente']);

                if ($response['estado'] == ElectronicReceiptService::responseSriTypeRecibida || $response['estado'] == ElectronicReceiptService::responseSriTypeEnProcesamiento) {
                    $remissionGuideSignedNumber = $request->infoTributaria['estab'] . '-' . $request->infoTributaria['ptoEmi'] . '-' . $request->infoTributaria['secuencial'];
                    $pathRemissionGuide = ElectronicReceiptService::partialPathElecetronicReceipt . '/remission_guides';
                    if (!Storage::exists('public/remission_guides'))
                        Storage::makeDirectory('public/remission_guides');
                    $pathSaveXmlSigned = storage_path($pathRemissionGuide . '/' . $remissionGuideSignedNumber . '.xml');
                    file_put_contents($pathSaveXmlSigned, $xmlSigned);

                    $response = $electronicReceiptService->sendElectronicReceiptToSriFromAuthorization($claveAcceso, $request->infoTributaria['ambiente']);
                }

                $verifyResponse = $electronicReceiptService->verifyResponse($response);

                $status = $verifyResponse['status'];

                if ($status == ElectronicReceiptService::responseSriTypeAutorizado || $status == ElectronicReceiptService::responseSriTypeEnProcesamiento) {
                    $remissionGuidesFolder = 'remission_guides';
                    $notificationService = new NotificationService();
                    $jsonDataDecode = json_decode(json_encode($request->all()));

                    // $electronicReceipstConstants = new ElectronicReceipstConstants();
                    // foreach ($jsonDataDecode->infoFactura->pagos as $pago) {
                    //     $spanishPaymentMethodName = $electronicReceipstConstants->getSpanishPaymentMethods($pago->formaPago);
                    //     $pago->formaPago = $spanishPaymentMethodName;
                    // }

                    $notificationService->sendEmailNotificationElectronicReceiptCreated(
                        $jsonDataDecode,
                        ElectronicReceipstConstants::REMISSION_GUIDE_SPANISH,
                        $request->infoGuiaRemision['razonSocialComprador'],
                        $request->infoTributaria['nombreComercial'],
                        $request->infoGuiaRemision['valorTotal'],
                        $remissionGuidesFolder,
                        'remissionGuide'
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
