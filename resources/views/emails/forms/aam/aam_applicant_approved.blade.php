<x-mail::message>

Hi {{ $applicationAdultMembershipRequest->name }},

**Your application has been approved by {{ $applicationAdultMembershipRequest->actionedBy->name }}.**


{{ $applicationAdultMembershipRequest->actioned_reason_external }}


Yours in Scouting,

Ssalute Administration

</x-mail::message>
