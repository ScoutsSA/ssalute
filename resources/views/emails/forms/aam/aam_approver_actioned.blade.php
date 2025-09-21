<x-mail::message>

Hey all,

Just to close the loop on this one!

The AAM Request has just been {{ $applicationAdultMembershipRequest->status->value }} by {{ $applicationAdultMembershipRequest->actionedBy->name }}.

You don't need to do anything here, but if you want to check all of the information out, you can click the button below:

<x-mail::button :url="$applicationAdultMembershipRequest->actionableLink">
View Application
</x-mail::button>


If you think this was in error, please reach out to {{ $applicationAdultMembershipRequest->actionedBy->name }} by simply reply to all here.


Yours in Scouting,

Ssalute Administration

</x-mail::message>
