<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Sale;

class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sale;

    /**
     * Create a new message instance.
     */
    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusText = $this->sale->payment_status === 'success' ? 'Invoice Lunas' : 'Proforma Invoice (Menunggu Pembayaran)';
        return new Envelope(
            from: new \Illuminate\Mail\Mailables\Address('sales@lktech.online', 'LKTech'),
            cc: [new \Illuminate\Mail\Mailables\Address('sales@lktech.online')],
            subject: $statusText . ' - ' . ($this->sale->payment_reference_id ?? 'LKTech'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice',
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

        if ($this->sale->payment_status === 'success') {
            $data = [
                'sale' => $this->sale,
                'company' => [
                    'name' => 'LK TECH',
                    'address' => 'Villa Mutiara 1 Sektor 2 BLOK i-18 No.03 Mekarwangi, Tanah Sereal, Bogor 16168',
                    'phone' => '0856-7354-046',
                    'email' => 'sales@lktech.online',
                ],
                'warranty_terms' => [
                    'Garansi 2 mgg hardware sejak pembelian. Segel utuh wajib.',
                    'Garansi Lifetime software (OS & MS Word) s.d tidak di-uninstall.',
                    'Batal jika cacat fisik (jatuh/kena air/modifikasi).',
                ],
            ];

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('sales.invoice', $data);
            $pdf->setPaper('A4', 'portrait');
            $pdfContent = $pdf->output();

            $filename = 'Invoice-LKTECH-' . str_pad($this->sale->id, 6, '0', STR_PAD_LEFT) . '.pdf';

            $attachments[] = \Illuminate\Mail\Mailables\Attachment::fromData(fn () => $pdfContent, $filename)
                ->withMime('application/pdf');
        }

        return $attachments;
    }
}
