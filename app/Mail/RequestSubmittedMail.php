<?php

namespace App\Mail;

use App\Models\Request\Request as RequestModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestSubmittedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public int $tries = 3;

    public array $backoff = [60, 300, 900];

    public function __construct(
        public RequestModel $request,
        public bool $forCompany
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->forCompany
            ? 'Новая заявка №'.$this->request->number
            : 'Мы получили вашу заявку №'.$this->request->number;

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.requests.submitted',
            text: 'emails.requests.submitted-text',
            with: [
                'request' => $this->request,
                'forCompany' => $this->forCompany,
            ],
        );
    }
}
