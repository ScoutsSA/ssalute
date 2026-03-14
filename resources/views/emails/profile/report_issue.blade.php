<x-mail::message>
# Issue Report

{{ $sentToNational ? 'This issue has been sent to the **National Adult Support Team**.' : 'This issue has been sent to the **next in line scouter**.' }}

---

## Reporter Details

| | |
|---|---|
| **Name** | {{ $reporter->name }} |
| **SSA ID** | {{ $reporter->ssaId }} |
| **Email** | {{ $reporter->username }} |
@foreach ($reporter->activeRoleAttachments as $role)
| **Role** | {{ $role->role?->name }}{{ $role->group ? ' — ' . $role->group->name : '' }}{{ $role->district ? ' — ' . $role->district->name : '' }}{{ $role->region ? ' — ' . $role->region->name : '' }} |
@endforeach

---

## Issue Description

{{ $description }}

---

Yours in Scouting,

Ssalute Administration
</x-mail::message>
