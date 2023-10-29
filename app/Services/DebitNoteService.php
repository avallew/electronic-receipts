<?php

namespace App\Services;

use App\SRI\Templates\XML\DebitNote100;
use App\Utilities\Constants\ElectronicReceipstConstants;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DebitNoteService
{
    public function generateTemplateXmlDebitNote($request)
    {
        $debit_note_type = ElectronicReceipstConstants::RECEIPT_TYPE_DEBIT_NOTE;
        $electronicReceiptService = new ElectronicReceiptService();
        switch ($request->typeElectronicReceipt['version']) {
            case ElectronicReceipstConstants::DEBIT_NOTE_VERSION_100:
                $debitNoteData = new DebitNote100();

                $debitNoteData->infoTributaria = $request->infoTributaria;
                $debitNoteData->infoTributaria['codDoc'] = $debit_note_type;
                $claveAcceso = $electronicReceiptService->getAccessKey(
                    $request->infoNotaDebito['fechaEmision'],
                    $request->infoTributaria['estab'] . $request->infoTributaria['ptoEmi'] . $request->infoTributaria['secuencial'],
                    $request->infoTributaria['ruc'],
                    $debit_note_type,
                    $request->infoTributaria['ambiente'],
                    $request->infoTributaria['tipoEmision']
                );
                $debitNoteData->infoTributaria['claveAcceso'] = $claveAcceso;
                $infoNotaDebito = $request->infoNotaDebito;
                $infoNotaDebito['fechaEmision'] = Carbon::parse($request->infoNotaDebito['fechaEmision'])->format('d/m/Y');

                $debitNoteData->infoNotaDebito = $infoNotaDebito;
                $debitNoteData->motivos = $request->motivos;
                $debitNoteData->infoAdicional = $request->infoAdicional;
                $debitNoteArray = $debitNoteData->notaDebito();

                $debitNoteXml = $electronicReceiptService->arrayToXml($debitNoteArray, 'notaDebito', ElectronicReceipstConstants::DEBIT_NOTE_VERSION_100);
                $signService = new SignService();
                $xmlSigned = $signService->signer($debitNoteXml);

                $response = $electronicReceiptService->sendElectronicReceiptToSriFromReception($xmlSigned, $request->infoTributaria['ambiente']);

                if ($response['estado'] == ElectronicReceiptService::responseSriTypeRecibida || $response['estado'] == ElectronicReceiptService::responseSriTypeEnProcesamiento) {
                    $debitNoteSignedNumber = $request->infoTributaria['estab'] . '-' . $request->infoTributaria['ptoEmi'] . '-' . $request->infoTributaria['secuencial'];
                    $pathDebitNotes = ElectronicReceiptService::partialPathElecetronicReceipt . '/debit_notes';
                    if (!Storage::exists('public/debit_notes'))
                        Storage::makeDirectory('public/debit_notes');
                    $pathSaveXmlSigned = storage_path($pathDebitNotes . '/' . $debitNoteSignedNumber . '.xml');
                    file_put_contents($pathSaveXmlSigned, $xmlSigned);

                    $response = $electronicReceiptService->sendElectronicReceiptToSriFromAuthorization($claveAcceso, $request->infoTributaria['ambiente']);
                }

                $verifyResponse = $electronicReceiptService->verifyResponse($response);

                $status = $verifyResponse['status'];

                if ($status == ElectronicReceiptService::responseSriTypeAutorizado || $status == ElectronicReceiptService::responseSriTypeEnProcesamiento) {
                    $debitNotesFolder = 'debit_notes';
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
                        $request->infoNotaDebito['razonSocialComprador'],
                        $request->infoTributaria['nombreComercial'],
                        $request->infoNotaDebito['valorTotal'],
                        $debitNotesFolder,
                        'debitNote'
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
