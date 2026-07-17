<?php

namespace App\Sync\Anonymizers;

use App\Sync\Anonymizers\Concerns\ScrubsColumns;

/**
 * Scrubs personal contact and financial details that live outside the member table:
 * group and event banking details, landlord and insurance contacts on properties,
 * professional directory and information-sharing contacts, and the full applicant
 * PII captured on adult-appointment (AAM) request forms. Organisation names and
 * locations are left intact; only personal and financial fields are neutralised.
 */
class AnonymizeOrganisationContacts
{
    use ScrubsColumns;

    public function __invoke(string $connection): void
    {
        foreach ($this->tableReplacements() as $table => $values) {
            $this->bulkScrub($connection, $table, $values);
        }
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    protected function tableReplacements(): array
    {
        $email = 'redacted@example.test';
        $phone = '0800000000';

        return [
            'groups' => [
                'email' => $email,
                'bankingDetails' => '',
                'bankAccountName' => '',
                'bankName' => '',
                'branchName' => '',
                'bankAccountNumber' => '',
            ],
            'group_events' => [
                'managementEmail' => $email,
                'bankName' => '',
                'bankAccountName' => '',
                'bankBranch' => '',
                'bankCode' => '',
                'bankAccountNumber' => '',
            ],
            'event_booking_setup_changes' => [
                'emailAddress' => $email,
                'bankName' => '',
                'bankAccountHoldersName' => '',
                'banlBranchName' => '',
                'bankBranchCode' => '',
                'bankAccountNumber' => '',
            ],
            'groups_property' => [
                'landlordName' => '',
                'landlordContactPerson' => '',
                'landlordContactPersonCell' => $phone,
                'landlordContactPersonEmail' => $email,
                'insuranceContactPerson' => '',
                'insuranceContactPersonCell' => $phone,
                'insuranceContactPersonEmail' => $email,
            ],
            'directory_professional' => [
                'contactPersonName' => '',
                'contactEmail' => $email,
                'contactTel' => $phone,
            ],
            'info_sharing' => [
                'contactPerson' => '',
                'email' => $email,
                'address' => 'Redacted',
            ],
            'jamboree_scouters' => [
                'scouterEmail' => $email,
            ],
            'ams_training_locations' => [
                'email' => $email,
                'contact' => '',
                'cell' => $phone,
                'address' => 'Redacted',
            ],
            'commerce_stock_locations' => [
                'contactName' => '',
                'contactCell' => $phone,
                'contactEmail' => $email,
                'physAddress' => 'Redacted',
            ],
            'commerce_stock_suppliers' => [
                'contactName' => '',
                'contactCell' => $phone,
                'contactEmail' => $email,
                'physAddress' => 'Redacted',
            ],
            'commerce_delivery_address' => [
                'name' => 'Redacted',
                'complexName' => '',
                'streetName' => 'Redacted',
            ],
            'forms_aam_requests' => [
                'first_name' => 'Applicant',
                'other_names' => '',
                'surname' => 'Redacted',
                'nickname' => '',
                'id_number' => '',
                'id_document' => '',
                'criminal_record' => '',
                'date_of_birth' => '2000-01-01',
                'passport_country' => '',
                'passport_date_of_issue' => '',
                'phone_number' => $phone,
                'email' => $email,
                'residential_address' => 'Redacted',
                'medical_conditions' => '',
                'medical_aid_scheme_name' => '',
                'medical_aid_number' => '',
                'medical_aid_principal_member' => '',
                'emergency_contact_name' => '',
                'emergency_contact_phone_number' => $phone,
            ],
        ];
    }
}
