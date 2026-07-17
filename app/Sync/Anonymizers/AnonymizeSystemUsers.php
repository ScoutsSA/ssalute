<?php

namespace App\Sync\Anonymizers;

use App\Sync\Anonymizers\Concerns\ScrubsColumns;

/**
 * Scrubs the `system_users` member identity table, the most sensitive table in
 * the Scouts schema. It carries names, ID and passport numbers, dates of birth,
 * addresses, GPS coordinates, every phone number, full medical history, next-of-kin
 * details and login credentials for tens of thousands of members, many of them
 * minors. Identity fields are replaced with deterministic per-member fakes so the
 * UI still shows distinct members, and free-text sensitive fields are blanked.
 */
class AnonymizeSystemUsers
{
    use ScrubsColumns;

    public function __invoke(string $connection): void
    {
        $this->perRowScrub(
            $connection,
            'system_users',
            array_keys($this->replacementsFor(0)),
            fn (string $column, object $row): mixed => $this->replacementsFor((int) $row->id)[$column],
        );
    }

    /**
     * The replacement value for every scrubbed column, derived from the member id
     * so emails, usernames, id numbers and cell numbers stay unique per row.
     *
     * @return array<string, mixed>
     */
    protected function replacementsFor(int $id): array
    {
        return [
            'username' => "member{$id}@example.test",
            'passwordNew' => '',
            'remember_token' => null,
            'title' => 'Mx',
            'first_name' => 'Member',
            'otherName' => '',
            'surname' => "No{$id}",
            'previousSurname' => '',
            'knownName' => '',
            'scoutName' => '',
            'photo' => '',
            'thumb' => '',
            'idNumber' => str_pad((string) $id, 13, '0', STR_PAD_LEFT),
            'IDBookLocation' => '',
            'passportNumber' => '',
            'partnersFullName' => '',
            'race' => '',
            'dob' => '2000-01-01',
            'phys_address' => 'Redacted',
            'postal_address' => 'Redacted',
            'gpsLat' => '',
            'gpsLon' => '',
            'cellNr' => '0800' . str_pad((string) $id, 7, '0', STR_PAD_LEFT),
            'officeNr' => '',
            'homeNr' => '',
            'faxNr' => '',
            'medicalAidName' => '',
            'medicalAidNr' => '',
            'medicalAidPrincipalMember' => '',
            'doctorsName' => '',
            'doctorsPhone' => '',
            'allergies' => '',
            'allergiesInstructions' => '',
            'disabilities' => '',
            'disabilitiesInstructions' => '',
            'medicalConditions' => '',
            'medicalConditionsInstructions' => '',
            'currentMedication' => '',
            'emergencyContactName' => '',
            'emergencyContactCell' => '',
            'emergencyContactTel' => '',
            'emergencyContactRelationship' => '',
            'specialMealRequirements' => '',
            'religiousAffilliation' => '',
            'religiousAffiliation' => '',
            'religion' => '',
            'religiousBelief' => '',
            'school' => '',
            'occupation' => '',
            'employer' => '',
            'ref1Name' => '',
            'ref1Address' => '',
            'ref1Tel' => '',
            'ref2Name' => '',
            'ref2Address' => '',
            'ref2Tel' => '',
        ];
    }
}
