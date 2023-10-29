<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\ElectronicCreditNoteRequest;
use App\Http\Requests\ElectronicDebitNoteRequest;
use App\Http\Requests\ElectronicInvoiceRequest;
use App\Http\Requests\ElectronicPurchaseLiquidationRequest;
use App\Http\Requests\ElectronicRemissionGuideRequest;
use App\Http\Requests\ElectronicRetentionReceiptRequest;
use App\Services\CreditNoteService;
use App\Services\DebitNoteService;
use App\Services\ElectronicReceiptService;
use App\Services\InvoiceService;
use App\Services\PurchaseLiquidationService;
use App\Services\RemissionGuideService;
use App\Services\RetentionReceiptService;
use App\Utilities\Constants\ElectronicReceipstConstants;
use Illuminate\Http\Request;

class ElectronicReceiptsController extends Controller
{
    // public function generateTemplateXml(ElectronicInvoiceRequest $request)
    public function generateTemplateXml(Request $request)
    {
        // $electronicReceipstConstants = new ElectronicReceipstConstants();
        // $arrayBuyers = $electronicReceipstConstants->getValidationIdentificationBuyer();

        // $type = null;
        // foreach ($arrayBuyers as $key => $value) {
        //     if ($value == $request->infoFactura['tipoIdentificacionComprador']) {
        //         $parts = explode("_", $key);
        //         $type = end($parts);
        //     }
        // }

        // $helper = new Helpers();
        // $identification = $request->infoFactura['identificacionComprador'];
        // return $helper->validarIdentification($type, $identification);

        $electronicReceiptService = new ElectronicReceiptService();
        switch ($request->typeElectronicReceipt['type']) {
            case ElectronicReceipstConstants::INVOICE:
                app(ElectronicInvoiceRequest::class)->validated();
                $invocieService = new InvoiceService();
                $data = $invocieService->generateTemplateXmlInvoice($request);
                break;
            case ElectronicReceipstConstants::DEBIT_NOTE:
                app(ElectronicDebitNoteRequest::class)->validated();
                $debitNoteService = new DebitNoteService();
                $data = $debitNoteService->generateTemplateXmlDebitNote($request);
                break;
            case ElectronicReceipstConstants::CREDIT_NOTE:
                app(ElectronicCreditNoteRequest::class)->validated();
                $creditNoteService = new CreditNoteService();
                $data = $creditNoteService->generateTemplateXmlCreditNote($request);
                break;
            case ElectronicReceipstConstants::REMISSION_GUIDE:
                app(ElectronicRemissionGuideRequest::class)->validated();
                $remissionGuideService = new RemissionGuideService();
                $data = $remissionGuideService->generateTemplateXmlRemissionGuide($request);
                break;
            case ElectronicReceipstConstants::PURCHASE_LIQUIDATION:
                app(ElectronicPurchaseLiquidationRequest::class)->validated();
                $purchaseLiquidationService = new PurchaseLiquidationService();
                $data = $purchaseLiquidationService->generateTemplateXmlPurchaseLiquidation($request);
                break;
            case ElectronicReceipstConstants::RETENTION_RECEIPT:
                app(ElectronicRetentionReceiptRequest::class)->validated();
                $retentionReceiptService = new RetentionReceiptService();
                $data = $retentionReceiptService->generateTemplateXmlRetentionReceipt($request);
                break;
        }
        return $data;
    }

    public function authElectronicReceipt(Request $request)
    {
        $electronicReceiptService = new ElectronicReceiptService();
        $response = $electronicReceiptService->sendElectronicReceiptToSriFromAuthorization($request->accessKey, $request->environment);
        return $electronicReceiptService->verifyResponse($response);
    }
}
