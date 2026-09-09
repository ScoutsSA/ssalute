<?php

namespace App\Filament\Admin\Resources\Users\RelationManagers\Concerns;

use App\Models\SystemUser;
use App\Models\SystemUsersOtherRole;

/**
 * The legacy AMS record tables (`ams_award_info`, `ams_documents`, `ams_past_service_info`,
 * `ams_training_past`, `ams_warrant_info`, `ams_charge_info`) declare the member's home area
 * and the `createdby` column `NOT NULL`, and Scouts Digital fills them on every insert. The
 * BackOffice forms never ask for them, so a create from a user's tab copies them from the
 * owning member here.
 */
trait FillsOwnerScopeOnCreate
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function withOwnerScope(array $data): array
    {
        /** @var SystemUser $owner */
        $owner = $this->getOwnerRecord();

        return [
            ...$data,
            'countryID' => SystemUsersOtherRole::DEFAULT_COUNTRY_ID,
            'assocToRegion' => $owner->assoc_to_region ?? 0,
            'assocToDistrict' => $owner->assoc_to_district ?? 0,
            'assocToGroup' => $owner->assoc_to_group ?? 0,
            'active' => $data['active'] ?? 1,
            'created' => now(),
            'createdby' => auth()->id(),
        ];
    }
}
