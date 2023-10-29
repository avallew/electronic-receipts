<?php

namespace App\Services;

use App\SRI\Templates\XML\CreditNote110;
use App\Utilities\Constants\ElectronicReceipstConstants;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CreditNoteService
{
    public function generateTemplateXmlCreditNote($request)
    {
        $credit_note_type = ElectronicReceipstConstants::RECEIPT_TYPE_CREDIT_NOTE;
        $electronicReceiptService = new ElectronicReceiptService();
        switch ($request->typeElectronicReceipt['version']) {
            case ElectronicReceipstConstants::CREDIT_NOTE_VERSION_110:
                $creditNoteData = new CreditNote110();

                $creditNoteData->infoTributaria = $request->infoTributaria;
                $creditNoteData->infoTributaria['codDoc'] = $credit_note_type;
                $claveAcceso = $electronicReceiptService->getAccessKey(
                    $request->infoNotaCredito['fechaEmision'],
                    $request->infoTributaria['estab'] . $request->infoTributaria['ptoEmi'] . $request->infoTributaria['secuencial'],
                    $request->infoTributaria['ruc'],
                    $credit_note_type,
                    $request->infoTributaria['ambiente'],
                    $request->infoTributaria['tipoEmision']
                );

                $creditNoteData->infoTributaria['claveAcceso'] = $claveAcceso;
                $infoNotaCredito = $request->infoNotaCredito;
                $infoNotaCredito['fechaEmision'] = Carbon::parse($request->infoNotaCredito['fechaEmision'])->format('d/m/Y');

                $creditNoteData->infoNotaCredito = $infoNotaCredito;
                $creditNoteData->detalles = $request->detalles;
                $creditNoteData->infoAdicional = $request->infoAdicional;
                $creditNoteArray = $creditNoteData->notaCredito();

                $creditNoteXml = $electronicReceiptService->arrayToXml($creditNoteArray, 'notaCredito', ElectronicReceipstConstants::CREDIT_NOTE_VERSION_110);
                $signService = new SignService();
                $xmlSigned = $signService->signer($creditNoteXml);

                $response = $electronicReceiptService->sendElectronicReceiptToSriFromReception($xmlSigned, $request->infoTributaria['ambiente']);

                if ($response['estado'] == ElectronicReceiptService::responseSriTypeRecibida || $response['estado'] ==  ElectronicReceiptService::responseSriTypeEnProcesamiento) {
                    $creditNoteSignedNumber = $request->infoTributaria['estab'] . '-' . $request->infoTributaria['ptoEmi'] . '-' . $request->infoTributaria['secuencial'];
                    $pathCreditNotes = ElectronicReceiptService::partialPathElecetronicReceipt . '/credit_notes';
                    if (!Storage::exists('public/credit_notes'))
                        Storage::makeDirectory('public/credit_notes');
                    $pathSaveXmlSigned = storage_path($pathCreditNotes . '/' . $creditNoteSignedNumber . '.xml');
                    file_put_contents($pathSaveXmlSigned, $xmlSigned);

                    $response = $electronicReceiptService->sendElectronicReceiptToSriFromAuthorization($claveAcceso, $request->infoTributaria['ambiente']);
                }

                $verifyResponse = $electronicReceiptService->verifyResponse($response);

                $status = $verifyResponse['status'];

                if ($status == ElectronicReceiptService::responseSriTypeAutorizado || $status == ElectronicReceiptService::responseSriTypeEnProcesamiento) {
                    $creditNotesFolder = 'credit_notes';
                    $notificationService = new NotificationService();
                    $jsonDataDecode = json_decode(json_encode($request->all()));

                    // $electronicReceipstConstants = new ElectronicReceipstConstants();
                    // foreach ($jsonDataDecode->infoFactura->pagos as $pago) {
                    //     $spanishPaymentMethodName = $electronicReceipstConstants->getSpanishPaymentMethods($pago->formaPago);
                    //     $pago->formaPago = $spanishPaymentMethodName;
                    // }

                    $notificationService->sendEmailNotificationElectronicReceiptCreated(
                        $jsonDataDecode,
                        ElectronicReceipstConstants::CREDIT_NOTE_SPANISH,
                        $request->infoNotaCredito['razonSocialComprador'],
                        $request->infoTributaria['nombreComercial'],
                        $request->infoNotaCredito['valorTotal'],
                        $creditNotesFolder,
                        'creditNote'
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
