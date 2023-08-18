<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Ticket $ticket
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket Created',
            to: 'admin@admin.com'
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.ticket-created',
            with: [
                'ticket' => $this->ticket,
                'url' => route('tickets.edit', $this->ticket),
            ],
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
