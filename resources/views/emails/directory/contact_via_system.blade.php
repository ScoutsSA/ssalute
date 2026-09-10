<x-mail::message>
# Message from {{ $sender->name }}

{{ $sender->name }} found you in the SCOUTS South Africa directory and sent you this message through the system.
@if ($recipient->infoRedacted === 1)
Your email address and cell number have not been shared with them.
@endif
Replying to this email will send your reply directly to {{ $sender->name }} at {{ $sender->username }}.

---

{{ $messageBody }}

---

Yours in Scouting,

Ssalute Administration
</x-mail::message>
