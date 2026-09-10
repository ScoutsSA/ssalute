<?php

namespace App\Mail\Directory;

use App\Models\SystemUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * A message relayed through the system to a member who has redacted their contact details.
 * The recipient's address is never shown to the sender; replies go to the sender directly.
 */
class ContactViaSystemEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public SystemUser $sender, public SystemUser $recipient, public string $subjectLine, public string $messageBody) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
            replyTo: [new Address($this->sender->username, $this->sender->name)],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.directory.contact_via_system',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
