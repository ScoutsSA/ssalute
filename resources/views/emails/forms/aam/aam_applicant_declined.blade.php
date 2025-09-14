<x-mail::message>

Hi {{ $applicationAdultMembershipRequest->name }},

Unfortunately your application has been declined.

Reason: {{ $applicationAdultMembershipRequest->decline_reason }}

If you'd like to query this, please contact your next in-line Scouter.


Yours in Scouting,

Ssalute Administration

</x-mail::message>
