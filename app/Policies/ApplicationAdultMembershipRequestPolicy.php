<?php

namespace App\Policies;

use App\Enums\Forms\Aam\AamStatuses;
use App\Models\Forms\ApplicationAdultMembershipRequest;
use App\Models\SystemUser;

class ApplicationAdultMembershipRequestPolicy
{
    public function view(SystemUser $user, ApplicationAdultMembershipRequest $request): bool
    {
        return $request->scoutersWhoCanApprove->contains('id', $user->id)
            || $user->isSuperAdmin();
    }

    public function approve(SystemUser $user, ApplicationAdultMembershipRequest $request): bool
    {
        return $this->view($user, $request)
            && $request->status === AamStatuses::PENDING;
    }

    public function decline(SystemUser $user, ApplicationAdultMembershipRequest $request): bool
    {
        return $this->view($user, $request)
            && $request->status === AamStatuses::PENDING;
    }
}
