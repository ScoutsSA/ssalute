<?php

namespace App\Mail\Profile;

use App\Models\SystemUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportIssueEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public SystemUser $reporter, public string $description, public bool $sentToNational) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[ScoutsSA] Issue Report from {$this->reporter->name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.profile.report_issue',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
