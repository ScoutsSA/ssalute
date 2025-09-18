<x-mail::message>

Hi {{ $applicationAdultMembershipRequest->nextInLineScouter->name }},

Someone has just filled in an AAM form and you're our first point of contact for them!

We've cc'd in other relevant Scouters to help you out if you get stuck!

Please review the application linked below and approve or decline it.
If you have no idea who this person is, feel free to contact your next in line commissioner to help you out.

<x-mail::button :url="$applicationAdultMembershipRequest->actionableLink">
View Application
</x-mail::button>


Yours in Scouting,

Ssalute Administration

</x-mail::message>>
