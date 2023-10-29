<?php

namespace App\Jobs;

use App\Mail\ElectronicReceiptCreatedMailable;
use App\Services\ElectronicReceiptService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailElectroniReceiptCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 2;
    public $backoff = 60;

    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $electronicReceiptService = new ElectronicReceiptService();
        $pdfFile = $electronicReceiptService->generatePdfElectronicReceipt($this->data['data_for_pdf'], $this->data['document_number'], $this->data['document_pdf_type']);
        $email = new ElectronicReceiptCreatedMailable(
            $this->data['document_xml_path'],
            $this->data['client_name'],
            $this->data['electronic_receipt_type_spanish'],
            $this->data['document_emissor_name'],
            $this->data['document_number'],
            $this->data['total'],
            $pdfFile
        );
        Mail::to($this->data['email'])->send($email);
    }
}
