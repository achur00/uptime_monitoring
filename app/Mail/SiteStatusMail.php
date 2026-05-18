<?php

namespace App\Mail;

use App\Models\Monitor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SiteStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Monitor $monitor,
        public string $status
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Uptime Monitor Alert: Site ' . strtoupper($this->status)
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.site-status-changed'
        );
    }
}