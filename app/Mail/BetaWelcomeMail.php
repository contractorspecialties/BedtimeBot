<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BetaWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $parentName;
    public $signedUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(string $parentName, string $signedUrl)
    {
        $this->parentName = $parentName;
        $this->signedUrl = $signedUrl;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✨ Welcome to the BedTimeBot Beta!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.beta_welcome',
        );
    }
}