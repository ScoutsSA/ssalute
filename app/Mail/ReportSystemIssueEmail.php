<?php

namespace App\Mail;

use App\Models\SystemUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportSystemIssueEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public SystemUser $reporter, public string $description) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[Ssalute] System Issue Report from {$this->reporter->name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.report_system_issue',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
