<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompanyCreatedMailable extends Mailable
{
    use Queueable, SerializesModels;

    protected $comercial_name;
    /**
     * Create a new message instance.
     */
    // public function __construct(public $comercialName, public $username, public $password, public $color)
    public function __construct(public $comercialName, public $username, public $password, public $color, public $url, public $token)
    {
        $this->comercial_name = $comercialName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Illarli - Creación de Empresa (' . $this->comercial_name . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.illarli.companyCreated',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
