<?php

namespace App\Mail;

use App\Models\Bill;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Helpers\CurrencyHelper;

class BillPaidMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $bill;

    /**
     * Create a new message instance.
     */
    public function __construct(Bill $bill)
    {
        $this->bill = $bill->load(['flat', 'flat.building', 'flat.building.houseOwner', 'billCategory', 'tenant']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bill Payment Received - ' . $this->bill->billCategory->name . ' (' . date('M Y', strtotime($this->bill->year . '-' . $this->bill->month . '-01')) . ')',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.bill-paid',
            with: [
                'bill' => $this->bill,
                'tenant' => $this->bill->tenant,
                'flat' => $this->bill->flat,
                'building' => $this->bill->flat->building,
                'houseOwner' => $this->bill->flat->building->houseOwner,
                'category' => $this->bill->billCategory,
                'billMonth' => date('F Y', strtotime($this->bill->year . '-' . $this->bill->month . '-01')),
                'formattedAmount' => CurrencyHelper::format($this->bill->total_amount),
                'paidDate' => $this->bill->paid_date ? $this->bill->paid_date->format('M d, Y') : 'N/A',
            ]
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
