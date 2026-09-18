<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Service;

class ServiceInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $service;

    /**
     * Create a new message instance.
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address('sales@lktech.online', 'LKTech'),
            cc: [new \Illuminate\Mail\Mailables\Address('sales@lktech.online')],
            subject: 'Service Invoice - ' . ($this->service->service_id ?? 'LKTech'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.service_invoice',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('services.print', ['service' => $this->service]);
        $pdf->setPaper('A4', 'portrait');
        $pdfContent = $pdf->output();

        $filename = 'Service-LKTECH-' . str_pad($this->service->id, 6, '0', STR_PAD_LEFT) . '.pdf';

        $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromData(fn () => $pdfContent, $filename)
            ->withMime('application/pdf');

        return $attachments;
    }
}
