<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class ElectronicReceiptCreatedMailable extends Mailable
{
    use Queueable, SerializesModels;

    private $name_emissor;
    private $document_type;
    private $number_document;
    private $document_path;
    private $pdf_file;
    /**
     * Create a new message instance.
     */
    public function __construct($document_path, public $client_name, public $electronic_receipt_type, public $document_name_emissor, public $document_number, public $total, $pdf_file)
    {
        $this->document_type = $electronic_receipt_type;
        $this->name_emissor = $document_name_emissor;
        $this->number_document = $document_number;
        $this->document_path = $document_path;
        $this->pdf_file = $pdf_file;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->name_emissor . ' ha generado su ' . $this->document_type . ' ' . $this->number_document,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.illarli.electronicReceiptCreated',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // $attachment = $this->pdf_path->getContent();
        return [
            Attachment::fromPath($this->document_path)
                ->as('Factura Electrónica N° ' . $this->number_document . '.xml')
                ->withMime('application/xml'),
            // Attachment::fromPath($this->pdf_path)
            //     ->as('Factura Electrónica N° ' . $this->number_document . '.pdf')
            //     ->withMime('application/pdf'),

            Attachment::fromData(fn () => $this->pdf_file)
                ->as('Factura Electrónica N° ' . $this->number_document . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
