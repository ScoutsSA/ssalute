<?php

namespace App\Mail\Aam;

use App\Models\V3\V3ApplicationAdultMembershipRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationAdultMembershipApproverInitialEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public V3ApplicationAdultMembershipRequest $applicationAdultMembershipRequest)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[ScoutsSA][Application Adult Membership] {$this->applicationAdultMembershipRequest->name} - Pending",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.aam.aam_approver_initial',
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
