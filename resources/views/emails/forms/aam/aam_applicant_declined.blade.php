<x-mail::message>

Hi {{ $applicationAdultMembershipRequest->name }},

Unfortunately your application has been declined by {{ $applicationAdultMembershipRequest->actionedBy->name }}.

Reason: {{ $applicationAdultMembershipRequest->actioned_reason_external }}

If you'd like to query this, please contact your next in-line Scouter.


Yours in Scouting,

Ssalute Administration

</x-mail::message>
