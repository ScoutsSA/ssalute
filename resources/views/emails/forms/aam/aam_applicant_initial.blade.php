<x-mail::message>

Hi {{ $applicationAdultMembershipRequest->name }},

As of {{ $applicationAdultMembershipRequest->created_at->to() }},
You have successfully created an Application for Adult Membership with Scouts SA!

We have notified the relevant next in line Scouter as well as various other Adult Support members of your application and they should review your application shortly.

If you don't hear back in several days to a week, you are more than welcome to send a message to your relevant Scouter to speed up the process.

From a process perspective, we'll email you again once your application has been reviewed and actioned by the next in line Scouter.


We are looking forward to having you as part of our team!


You can track the status of your application by clicking the button below:

<x-mail::button :url="$applicationAdultMembershipRequest->viewableLink">
View Application
</x-mail::button>


Yours in Scouting,

Ssalute Administration

</x-mail::message>
