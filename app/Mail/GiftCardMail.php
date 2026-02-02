<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GiftCardMail extends Mailable
{
    use Queueable, SerializesModels;

    public $cards;
    public $orderId;

    /**
     * Create a new message instance.
     */
    public function __construct($cards, $orderId)
    {
        $this->cards = $cards;
        $this->orderId = $orderId;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Gift Card Codes ',
        );
    }

    /**
     * Get the message content definition.
     */
   public function content(): Content
{
    return new Content(
        view: 'emails.giftcard',
        with: [
            'cards'   => $this->cards,
            'orderId' => $this->orderId,
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
