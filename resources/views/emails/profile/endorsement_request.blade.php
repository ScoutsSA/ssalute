<x-mail::message>
# Endorsement Request

A member has submitted a request for endorsement to the **International Committee Representatives**.

---

## Requester Details

| | |
|---|---|
| **Name** | {{ $requester->name }} |
| **SSA ID** | {{ $requester->ssaId }} |
| **Email** | {{ $requester->username }} |
@foreach ($requester->activeRoleAttachments as $role)
| **Role** | {{ $role->role?->name }}{{ $role->group ? ' — ' . $role->group->name : '' }}{{ $role->district ? ' — ' . $role->district->name : '' }}{{ $role->region ? ' — ' . $role->region->name : '' }} |
@endforeach

---

## Subject

{{ $endorsementSubject }}

---

## Description

{{ $description }}

---

**Note:** This is a request for endorsement. Please review and respond to the requester directly.

Yours in Scouting,

Ssalute Administration
</x-mail::message>
