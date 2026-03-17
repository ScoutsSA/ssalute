<?php

namespace App\Mail\Profile;

use App\Models\SystemUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EndorsementRequestEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public SystemUser $requester, public string $endorsementSubject, public string $description) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[ScoutsSA] Endorsement Request from {$this->requester->name}",
        );
    }

    public function content(): Content
    {
        $this->requester->load('activeRoleAttachments.role', 'activeRoleAttachments.group', 'activeRoleAttachments.district', 'activeRoleAttachments.region');

        return new Content(
            markdown: 'emails.profile.endorsement_request',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
