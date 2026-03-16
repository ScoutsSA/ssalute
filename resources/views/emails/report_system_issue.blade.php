<x-mail::message>
# System Issue Report

This is a **system issue report** submitted via the Ssalute general panel.

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
