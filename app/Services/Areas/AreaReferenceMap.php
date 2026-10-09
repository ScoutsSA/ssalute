<?php

namespace App\Services\Areas;

use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Every column in the legacy schema that references a region, district or group.
 *
 * The REGION, DISTRICT and GROUP maps are generated from database/schema/sd-core-schema.sql
 * by matching the column naming conventions below. AreaReferenceMapTest re-derives them from the
 * dump and fails when they drift. The *_EXTRA maps hold references whose column names do not
 * follow the convention and are curated by hand; the same test asserts each one exists.
 *
 * The legacy schema has no foreign keys, so this map is the only record of what links to an area.
 */
final class AreaReferenceMap
{
    public const REGION_COLUMN_NAMES = ['regionID', 'assocToRegion', 'assoc_to_region'];

    public const DISTRICT_COLUMN_NAMES = ['districtID', 'assocToDistrict', 'assoc_to_district'];

    public const GROUP_COLUMN_NAMES = ['groupID', 'assocToGroup', 'assoc_to_group'];

    /**
     * Log tables that reference areas but neither block a delete nor get a linked record tab. Orphaned log rows
     * are harmless, every area that was ever used has some, and system_user_logging (close to a million rows)
     * has no index on its area columns.
     *
     * @var list<string>
     */
    public const NON_BLOCKING_TABLES = ['admin_good_logons', 'error_logging', 'notifications', 'notifications_archive', 'system_user_logging'];

    /** @var array<string, list<string>> */
    public const REGION_EXTRA = [
        'group_accounts_transfers' => ['fromRegionID', 'toRegionID'],
        'jamboree_application' => ['busRegionID'],
        'system_users_other_roles' => ['actionRegionID'],
    ];

    /** @var array<string, list<string>> */
    public const DISTRICT_EXTRA = [
        'ams_adult_leader_moves' => ['fromDistrict', 'toDistrict'],
        'group_accounts_transfers' => ['fromDistrictID', 'toDistrictID'],
        'group_events' => ['heldInDistrict'],
        'system_users_other_roles' => ['actionDistrictID'],
    ];

    /** @var array<string, list<string>> */
    public const GROUP_EXTRA = [
        'ams_adult_leader_moves' => ['fromGroup', 'toGroup'],
        'commerce_group_fees' => ['paidOutToGroup'],
        'commerce_wallet' => ['paidToGroup'],
        'group_accounts_transfers' => ['fromGroupID', 'toGroupID'],
        'system_users' => ['roverGroupID'],
        'system_users_other_roles' => ['actionGroupID'],
    ];

    /** @var array<string, string> */
    public const LABELS = [
        'admin_good_logons' => 'Logon records',
        'ams_warrant_info' => 'Warrants',
        'ams_warrant_applications' => 'Warrant applications',
        'ams_award_info' => 'Awards',
        'ams_training_past' => 'Training records',
        'districts' => 'Districts',
        'districts_super' => 'Super districts',
        'error_logging' => 'Error log entries',
        'group_accounts' => 'Accounts',
        'group_committee' => 'Committee members',
        'group_council' => 'Council members',
        'group_cub_packs' => 'Cub packs',
        'group_events' => 'Events',
        'group_meerkat_dens' => 'Meerkat dens',
        'group_programs' => 'Programs',
        'group_rover_crews' => 'Rover crews',
        'group_scout_troops' => 'Scout troops',
        'groups' => 'Groups',
        'notifications' => 'Notifications',
        'notifications_archive' => 'Archived notifications',
        'system_user_logging' => 'User activity log',
        'system_users' => 'Users (home area)',
        'system_users_other_roles' => 'Role attachments',
    ];

    public const REGION = [
        'admin_good_logons' => ['regionID'],
        'advancement_cubs' => ['assocToRegion'],
        'advancement_meerkats' => ['assocToRegion'],
        'advancement_rovers' => ['assocToRegion'],
        'advancement_scouts' => ['assocToRegion'],
        'ams_adult_leader_moves' => ['assocToRegion'],
        'ams_award_applications' => ['assocToRegion'],
        'ams_award_info' => ['assocToRegion'],
        'ams_charge_info' => ['assocToRegion'],
        'ams_criminal_check' => ['assocToRegion'],
        'ams_disciplinary_info' => ['assocToRegion'],
        'ams_documents' => ['assocToRegion'],
        'ams_documents_groups' => ['assocToRegion'],
        'ams_past_service_info' => ['assocToRegion'],
        'ams_resign_leader' => ['assocToRegion'],
        'ams_retire_leader' => ['assocToRegion'],
        'ams_suspend_leader' => ['assocToRegion'],
        'ams_terminate_leader' => ['assocToRegion'],
        'ams_training_courses' => ['assocToRegion'],
        'ams_training_courses_annual' => ['assocToRegion'],
        'ams_training_courses_annual_attendance' => ['assocToRegion'],
        'ams_training_courses_annual_bookings' => ['assocToRegion'],
        'ams_training_courses_annual_dates' => ['assocToRegion'],
        'ams_training_locations' => ['assocToRegion'],
        'ams_training_past' => ['assocToRegion'],
        'ams_warrant_applications' => ['assocToRegion'],
        'ams_warrant_extensions' => ['assocToRegion'],
        'ams_warrant_info' => ['assocToRegion'],
        'badges_cubs' => ['assocToRegion'],
        'badges_meerkats' => ['assocToRegion'],
        'badges_rovers' => ['assocToRegion'],
        'badges_scouts' => ['assocToRegion'],
        'census_documents' => ['regionID'],
        'commerce_group_fees' => ['regionID'],
        'commerce_orders' => ['regionID'],
        'commerce_search_queries' => ['regionID'],
        'districts' => ['regionID'],
        'districts_super' => ['regionID'],
        'error_logging' => ['regionID'],
        'event_competitions_location_logging' => ['regionID'],
        'group_accounts' => ['assocToRegion'],
        'group_committee' => ['assocToRegion'],
        'group_council' => ['assocToRegion'],
        'group_district_reports' => ['assocToRegion'],
        'group_district_reports_cubs' => ['assocToRegion'],
        'group_district_reports_cubs_attendance' => ['assocToRegion'],
        'group_district_reports_scouts' => ['assocToRegion'],
        'group_equipment' => ['assocToRegion'],
        'group_events' => ['assocToRegion'],
        'group_financial_annual_invoice_discounts' => ['assocToRegion'],
        'group_financial_credit_notes' => ['assocToRegion'],
        'group_financial_fees' => ['assocToRegion'],
        'group_financial_invoices' => ['assocToRegion'],
        'group_financial_payments_made' => ['assocToRegion'],
        'group_newsletters' => ['assocToRegion'],
        'group_parents_committee_minutes' => ['assocToRegion'],
        'group_programs' => ['assocToRegion'],
        'group_scout_troops' => ['assocToRegion'],
        'group_scouts_charges' => ['assocToRegion'],
        'group_scouts_patrol_names' => ['assocToRegion'],
        'group_star_awards' => ['regionID'],
        'group_youth_charges' => ['assocToRegion'],
        'groups' => ['assoc_to_region'],
        'groups_entsha_move' => ['regionID'],
        'groups_property' => ['regionID'],
        'jamboree_bus_info' => ['regionID'],
        'jamboree_eoi' => ['regionID'],
        'jamboree_expr_of_interest' => ['regionID'],
        'jamboree_position_offered' => ['regionID'],
        'notifications' => ['regionID'],
        'notifications_archive' => ['regionID'],
        'projects' => ['regionID'],
        'projects_supported' => ['regionID'],
        'reports_numbers' => ['assocToRegion'],
        'scouter_reviews' => ['regionID'],
        'star_awards' => ['regionID'],
        'support_chats_start' => ['regionID'],
        'system_user_logging' => ['regionID'],
        'system_users' => ['assoc_to_region'],
        'system_users_other_roles' => ['regionID'],
        'wsm16_expression' => ['regionID'],
    ];

    /** @var array<string, list<string>> */
    public const DISTRICT = [
        'admin_good_logons' => ['districtID'],
        'advancement_cubs' => ['assocToDistrict'],
        'advancement_meerkats' => ['assocToDistrict'],
        'advancement_rovers' => ['assocToDistrict'],
        'advancement_scouts' => ['assocToDistrict'],
        'ams_award_info' => ['assocToDistrict'],
        'ams_charge_info' => ['assocToDistrict'],
        'ams_disciplinary_info' => ['assocToDistrict'],
        'ams_documents' => ['assocToDistrict'],
        'ams_documents_groups' => ['assocToDistrict'],
        'ams_past_service_info' => ['assocToDistrict'],
        'ams_resign_leader' => ['assocToDistrict'],
        'ams_retire_leader' => ['assocToDistrict'],
        'ams_suspend_leader' => ['assocToDistrict'],
        'ams_terminate_leader' => ['assocToDistrict'],
        'ams_training_past' => ['assocToDistrict'],
        'ams_warrant_applications' => ['assocToDistrict'],
        'ams_warrant_extensions' => ['assocToDistrict'],
        'ams_warrant_info' => ['assocToDistrict'],
        'badges_cubs' => ['assocToDistrict'],
        'badges_meerkats' => ['assocToDistrict'],
        'badges_rovers' => ['assocToDistrict'],
        'badges_scouts' => ['assocToDistrict'],
        'census_documents' => ['districtID'],
        'commerce_group_fees' => ['districtID'],
        'commerce_orders' => ['districtID'],
        'commerce_search_queries' => ['districtID'],
        'error_logging' => ['districtID'],
        'event_competitions_location_logging' => ['districtID'],
        'group_accounts' => ['assocToDistrict'],
        'group_committee' => ['assocToDistrict'],
        'group_council' => ['assocToDistrict'],
        'group_district_reports' => ['assocToDistrict'],
        'group_district_reports_cubs' => ['assocToDistrict'],
        'group_district_reports_cubs_attendance' => ['assocToDistrict'],
        'group_district_reports_scouts' => ['assocToDistrict'],
        'group_equipment' => ['assocToDistrict'],
        'group_events' => ['assocToDistrict'],
        'group_financial_annual_invoice_discounts' => ['assocToDistrict'],
        'group_financial_credit_notes' => ['assocToDistrict'],
        'group_financial_fees' => ['assocToDistrict'],
        'group_financial_invoices' => ['assocToDistrict'],
        'group_financial_payments_made' => ['assocToDistrict'],
        'group_newsletters' => ['assocToDistrict'],
        'group_parents_committee_minutes' => ['assocToDistrict'],
        'group_programs' => ['assocToDistrict'],
        'group_scout_troops' => ['assocToDistrict'],
        'group_scouts_charges' => ['assocToDistrict'],
        'group_scouts_patrol_names' => ['assocToDistrict'],
        'group_star_awards' => ['districtID'],
        'group_youth_charges' => ['assocToDistrict'],
        'groups' => ['assoc_to_district'],
        'groups_entsha_move' => ['districtID'],
        'groups_property' => ['districtID'],
        'jamboree_eoi' => ['districtID'],
        'jamboree_expr_of_interest' => ['districtID'],
        'jamboree_position_offered' => ['districtID'],
        'notifications' => ['districtID'],
        'notifications_archive' => ['districtID'],
        'projects' => ['districtID'],
        'projects_supported' => ['districtID'],
        'reports_numbers' => ['assocToDistrict'],
        'scouter_reviews' => ['districtID'],
        'star_awards' => ['districtID'],
        'system_user_logging' => ['districtID'],
        'system_users' => ['assoc_to_district'],
        'system_users_other_roles' => ['districtID'],
        'wsm16_expression' => ['districtID'],
    ];

    /** @var array<string, list<string>> */
    public const GROUP = [
        'admin_good_logons' => ['groupID'],
        'advancement_cubs' => ['assocToGroup'],
        'advancement_documents' => ['assocToGroup'],
        'advancement_meerkats' => ['assocToGroup'],
        'advancement_notes' => ['assocToGroup'],
        'advancement_photos' => ['assocToGroup'],
        'advancement_rovers' => ['assocToGroup'],
        'advancement_scouters' => ['assocToGroup'],
        'advancement_scouts' => ['assocToGroup'],
        'ams_award_info' => ['assocToGroup'],
        'ams_charge_info' => ['assocToGroup'],
        'ams_disciplinary_info' => ['assocToGroup'],
        'ams_documents' => ['assocToGroup'],
        'ams_documents_groups' => ['assocToGroup'],
        'ams_past_service_info' => ['assocToGroup'],
        'ams_resign_leader' => ['assocToGroup'],
        'ams_retire_leader' => ['assocToGroup'],
        'ams_suspend_leader' => ['assocToGroup'],
        'ams_terminate_leader' => ['assocToGroup'],
        'ams_training_past' => ['assocToGroup'],
        'ams_warrant_applications' => ['assocToGroup'],
        'ams_warrant_extensions' => ['assocToGroup'],
        'ams_warrant_info' => ['assocToGroup'],
        'badges_cubs' => ['assocToGroup'],
        'badges_documents' => ['assocToGroup'],
        'badges_meerkats' => ['assocToGroup'],
        'badges_notes' => ['assocToGroup'],
        'badges_photos' => ['assocToGroup'],
        'badges_rovers' => ['assocToGroup'],
        'badges_scouts' => ['assocToGroup'],
        'census_documents' => ['groupID'],
        'commerce_group_fees' => ['groupID'],
        'commerce_orders' => ['groupID'],
        'commerce_products' => ['groupID'],
        'commerce_search_queries' => ['groupID'],
        'error_logging' => ['groupID'],
        'event_competitions_groups_attending' => ['groupID'],
        'event_competitions_location_logging' => ['groupID'],
        'group_accounts' => ['assocToGroup'],
        'group_advancements_in_events' => ['assocToGroup'],
        'group_advancements_in_programs' => ['assocToGroup'],
        'group_attendance' => ['assocToGroup'],
        'group_badges_in_events' => ['assocToGroup'],
        'group_badges_in_programs' => ['assocToGroup'],
        'group_committee' => ['assocToGroup'],
        'group_council' => ['assocToGroup'],
        'group_cub_packs' => ['assocToGroup'],
        'group_cubs_sixes_names' => ['assocToGroup'],
        'group_district_reports' => ['assocToGroup'],
        'group_district_reports_cubs' => ['assocToGroup'],
        'group_district_reports_cubs_attendance' => ['assocToGroup'],
        'group_district_reports_scouts' => ['assocToGroup'],
        'group_district_reports_scouts_attendance' => ['assocToGroup'],
        'group_documents' => ['assocToGroup'],
        'group_edit_record' => ['groupID'],
        'group_equipment' => ['assocToGroup'],
        'group_equipment_store' => ['assocToGroup'],
        'group_events' => ['assocToGroup'],
        'group_events_attending' => ['groupID'],
        'group_financial_annual_invoice_discounts' => ['assocToGroup'],
        'group_financial_credit_notes' => ['assocToGroup'],
        'group_financial_credit_notes_items' => ['assocToGroup'],
        'group_financial_fee_types' => ['assocToGroup'],
        'group_financial_fees' => ['assocToGroup'],
        'group_financial_invoices' => ['assocToGroup'],
        'group_financial_invoices_emailed' => ['assocToGroup'],
        'group_financial_invoices_items' => ['assocToGroup'],
        'group_financial_payments_made' => ['assocToGroup'],
        'group_financial_years' => ['assocToGroup'],
        'group_meerkat_dens' => ['assocToGroup'],
        'group_meerkats_patrol_names' => ['assocToGroup'],
        'group_newsletters' => ['assocToGroup'],
        'group_parents_committee_minutes' => ['assocToGroup'],
        'group_programs' => ['assocToGroup'],
        'group_rover_crews' => ['assocToGroup'],
        'group_rovers_patrol_names' => ['assocToGroup'],
        'group_scout_troops' => ['assocToGroup'],
        'group_scouts_charges' => ['assocToGroup'],
        'group_scouts_patrol_names' => ['assocToGroup'],
        'group_star_awards' => ['groupID'],
        'group_weekly_emails_emailed' => ['assocToGroup'],
        'group_youth_charges' => ['assocToGroup'],
        'groups_entsha_move' => ['groupID'],
        'groups_multi' => ['groupID'],
        'groups_property' => ['groupID'],
        'groups_property_updates' => ['groupID'],
        'jamboree_eoi' => ['groupID'],
        'jamboree_expr_of_interest' => ['groupID'],
        'jamboree_position_offered' => ['groupID'],
        'notifications' => ['groupID'],
        'notifications_archive' => ['groupID'],
        'projects' => ['groupID'],
        'projects_supported' => ['groupID'],
        'reports_numbers' => ['assocToGroup'],
        'scouter_reviews' => ['groupID'],
        'sd_articles' => ['groupID'],
        'services_purchased' => ['groupID'],
        'services_purchased_spreadsheets_received' => ['groupID'],
        'services_purchased_spreadsheets_sent' => ['groupID'],
        'star_awards' => ['groupID'],
        'star_awards_notes' => ['groupID'],
        'system_user_logging' => ['groupID'],
        'system_users' => ['assoc_to_group'],
        'system_users_other_roles' => ['groupID'],
        'wsm16_expression' => ['groupID'],
    ];

    public const TABLES_WITHOUT_MODELS = ['commerce_group_fees', 'commerce_orders', 'commerce_products', 'commerce_search_queries', 'commerce_wallet'];

    /** @var array<string, class-string<Model>> */
    public const MODELS = [
        'admin_good_logons' => \App\Models\AdminGoodLogon::class,
        'advancement_cubs' => \App\Models\AdvancementCub::class,
        'advancement_documents' => \App\Models\AdvancementDocument::class,
        'advancement_meerkats' => \App\Models\AdvancementMeerkat::class,
        'advancement_notes' => \App\Models\AdvancementNote::class,
        'advancement_photos' => \App\Models\AdvancementPhoto::class,
        'advancement_rovers' => \App\Models\AdvancementRover::class,
        'advancement_scouters' => \App\Models\AdvancementScouter::class,
        'advancement_scouts' => \App\Models\AdvancementScout::class,
        'ams_adult_leader_moves' => \App\Models\AmsAdultLeaderMove::class,
        'ams_award_applications' => \App\Models\AmsAwardApplication::class,
        'ams_award_info' => \App\Models\Award::class,
        'ams_charge_info' => \App\Models\AmsLicenceInfo::class,
        'ams_criminal_check' => \App\Models\AmsCriminalCheck::class,
        'ams_disciplinary_info' => \App\Models\AmsDisciplinaryInfo::class,
        'ams_documents' => \App\Models\Document::class,
        'ams_documents_groups' => \App\Models\AmsDocumentsGroup::class,
        'ams_past_service_info' => \App\Models\PastService::class,
        'ams_resign_leader' => \App\Models\AmsResignLeader::class,
        'ams_retire_leader' => \App\Models\AmsRetireLeader::class,
        'ams_suspend_leader' => \App\Models\AmsSuspendLeader::class,
        'ams_terminate_leader' => \App\Models\AmsTerminateLeader::class,
        'ams_training_courses' => \App\Models\AmsTrainingCourse::class,
        'ams_training_courses_annual' => \App\Models\AmsTrainingCoursesAnnual::class,
        'ams_training_courses_annual_attendance' => \App\Models\AmsTrainingCoursesAnnualAttendance::class,
        'ams_training_courses_annual_bookings' => \App\Models\AmsTrainingCoursesAnnualBooking::class,
        'ams_training_courses_annual_dates' => \App\Models\AmsTrainingCoursesAnnualDate::class,
        'ams_training_locations' => \App\Models\AmsTrainingLocation::class,
        'ams_training_past' => \App\Models\PastTraining::class,
        'ams_warrant_applications' => \App\Models\AmsWarrantApplication::class,
        'ams_warrant_extensions' => \App\Models\AmsWarrantExtension::class,
        'ams_warrant_info' => \App\Models\AmsWarrantInfo::class,
        'badges_cubs' => \App\Models\BadgesCub::class,
        'badges_documents' => \App\Models\BadgesDocument::class,
        'badges_meerkats' => \App\Models\BadgesMeerkat::class,
        'badges_notes' => \App\Models\BadgesNote::class,
        'badges_photos' => \App\Models\BadgesPhoto::class,
        'badges_rovers' => \App\Models\BadgesRover::class,
        'badges_scouts' => \App\Models\BadgesScout::class,
        'census_documents' => \App\Models\CensusDocument::class,
        'districts' => \App\Models\District::class,
        'districts_super' => \App\Models\DistrictsSuper::class,
        'error_logging' => \App\Models\ErrorLogging::class,
        'event_competitions_groups_attending' => \App\Models\EventCompetitionsGroupsAttending::class,
        'event_competitions_location_logging' => \App\Models\EventCompetitionsLocationLogging::class,
        'group_accounts' => \App\Models\GroupAccount::class,
        'group_accounts_transfers' => \App\Models\GroupAccountsTransfer::class,
        'group_advancements_in_events' => \App\Models\GroupAdvancementsInEvent::class,
        'group_advancements_in_programs' => \App\Models\GroupAdvancementsInProgram::class,
        'group_attendance' => \App\Models\GroupAttendance::class,
        'group_badges_in_events' => \App\Models\GroupBadgesInEvent::class,
        'group_badges_in_programs' => \App\Models\GroupBadgesInProgram::class,
        'group_committee' => \App\Models\GroupCommittee::class,
        'group_council' => \App\Models\GroupCouncil::class,
        'group_cub_packs' => \App\Models\GroupCubPack::class,
        'group_cubs_sixes_names' => \App\Models\GroupCubsSixesName::class,
        'group_district_reports' => \App\Models\GroupDistrictReport::class,
        'group_district_reports_cubs' => \App\Models\GroupDistrictReportsCub::class,
        'group_district_reports_cubs_attendance' => \App\Models\GroupDistrictReportsCubsAttendance::class,
        'group_district_reports_scouts' => \App\Models\GroupDistrictReportsScout::class,
        'group_district_reports_scouts_attendance' => \App\Models\GroupDistrictReportsScoutsAttendance::class,
        'group_documents' => \App\Models\GroupDocument::class,
        'group_edit_record' => \App\Models\GroupEditRecord::class,
        'group_equipment' => \App\Models\GroupEquipment::class,
        'group_equipment_store' => \App\Models\GroupEquipmentStore::class,
        'group_events' => \App\Models\GroupEvent::class,
        'group_events_attending' => \App\Models\GroupEventsAttending::class,
        'group_financial_annual_invoice_discounts' => \App\Models\GroupFinancialAnnualInvoiceDiscount::class,
        'group_financial_credit_notes' => \App\Models\GroupFinancialCreditNote::class,
        'group_financial_credit_notes_items' => \App\Models\GroupFinancialCreditNotesItem::class,
        'group_financial_fee_types' => \App\Models\GroupFinancialFeeType::class,
        'group_financial_fees' => \App\Models\GroupFinancialFee::class,
        'group_financial_invoices' => \App\Models\GroupFinancialInvoice::class,
        'group_financial_invoices_emailed' => \App\Models\GroupFinancialInvoicesEmailed::class,
        'group_financial_invoices_items' => \App\Models\GroupFinancialInvoicesItem::class,
        'group_financial_payments_made' => \App\Models\GroupFinancialPaymentsMade::class,
        'group_financial_years' => \App\Models\GroupFinancialYear::class,
        'group_meerkat_dens' => \App\Models\GroupMeerkatDen::class,
        'group_meerkats_patrol_names' => \App\Models\GroupMeerkatsPatrolName::class,
        'group_newsletters' => \App\Models\GroupNewsletter::class,
        'group_parents_committee_minutes' => \App\Models\GroupParentsCommitteeMinute::class,
        'group_programs' => \App\Models\GroupProgram::class,
        'group_rover_crews' => \App\Models\GroupRoverCrew::class,
        'group_rovers_patrol_names' => \App\Models\GroupRoversPatrolName::class,
        'group_scout_troops' => \App\Models\GroupScoutTroop::class,
        'group_scouts_charges' => \App\Models\GroupScoutsCharge::class,
        'group_scouts_patrol_names' => \App\Models\GroupScoutsPatrolName::class,
        'group_star_awards' => \App\Models\GroupStarAward::class,
        'group_weekly_emails_emailed' => \App\Models\GroupWeeklyEmailsEmailed::class,
        'group_youth_charges' => \App\Models\GroupYouthCharge::class,
        'groups' => \App\Models\Group::class,
        'groups_entsha_move' => \App\Models\GroupsEntshaMove::class,
        'groups_multi' => \App\Models\GroupsMulti::class,
        'groups_property' => \App\Models\GroupsProperty::class,
        'groups_property_updates' => \App\Models\GroupsPropertyUpdate::class,
        'jamboree_application' => \App\Models\JamboreeApplication::class,
        'jamboree_bus_info' => \App\Models\JamboreeBusInfo::class,
        'jamboree_eoi' => \App\Models\JamboreeEoi::class,
        'jamboree_expr_of_interest' => \App\Models\JamboreeExprOfInterest::class,
        'jamboree_position_offered' => \App\Models\JamboreePositionOffered::class,
        'notifications' => \App\Models\Notification::class,
        'notifications_archive' => \App\Models\NotificationsArchive::class,
        'projects' => \App\Models\Project::class,
        'projects_supported' => \App\Models\ProjectsSupported::class,
        'reports_numbers' => \App\Models\ReportsNumber::class,
        'scouter_reviews' => \App\Models\ScouterReview::class,
        'sd_articles' => \App\Models\SdArticle::class,
        'services_purchased' => \App\Models\ServicesPurchased::class,
        'services_purchased_spreadsheets_received' => \App\Models\ServicesPurchasedSpreadsheetsReceived::class,
        'services_purchased_spreadsheets_sent' => \App\Models\ServicesPurchasedSpreadsheetsSent::class,
        'star_awards' => \App\Models\StarAward::class,
        'star_awards_notes' => \App\Models\StarAwardsNote::class,
        'support_chats_start' => \App\Models\SupportChatsStart::class,
        'system_user_logging' => \App\Models\SystemUserLogging::class,
        'system_users' => \App\Models\SystemUser::class,
        'system_users_other_roles' => \App\Models\SystemUsersOtherRole::class,
        'wsm16_expression' => \App\Models\Wsm16Expression::class,
    ];

    /**
     * Column naming conventions for the given area level.
     *
     * @return list<string>
     */
    public static function columnNamesFor(string $modelClass): array
    {
        return match ($modelClass) {
            Region::class => self::REGION_COLUMN_NAMES,
            District::class => self::DISTRICT_COLUMN_NAMES,
            Group::class => self::GROUP_COLUMN_NAMES,
        };
    }

    /**
     * Canonical (convention derived) references for the given area level.
     *
     * @return array<string, list<string>>
     */
    public static function canonicalFor(string $modelClass): array
    {
        return match ($modelClass) {
            Region::class => self::REGION,
            District::class => self::DISTRICT,
            Group::class => self::GROUP,
        };
    }

    /**
     * Hand curated references for the given area level.
     *
     * @return array<string, list<string>>
     */
    public static function extraFor(string $modelClass): array
    {
        return match ($modelClass) {
            Region::class => self::REGION_EXTRA,
            District::class => self::DISTRICT_EXTRA,
            Group::class => self::GROUP_EXTRA,
        };
    }

    /**
     * Every referencing column for the given area level, table => columns.
     *
     * @return array<string, list<string>>
     */
    public static function for(string $modelClass): array
    {
        $map = self::canonicalFor($modelClass);

        foreach (self::extraFor($modelClass) as $table => $columns) {
            $map[$table] = array_values(array_unique([...($map[$table] ?? []), ...$columns]));
        }

        ksort($map);

        return $map;
    }

    /**
     * The referencing columns that block a delete and get a linked record tab: for() without NON_BLOCKING_TABLES.
     *
     * @return array<string, list<string>>
     */
    public static function blockingFor(string $modelClass): array
    {
        return array_diff_key(self::for($modelClass), array_flip(self::NON_BLOCKING_TABLES));
    }

    public static function isBlocking(string $table): bool
    {
        return ! in_array($table, self::NON_BLOCKING_TABLES, true);
    }

    /**
     * @return class-string<Model>|null
     */
    public static function modelFor(string $table): ?string
    {
        return self::MODELS[$table] ?? null;
    }

    public static function label(string $table): string
    {
        return self::LABELS[$table] ?? Str::headline($table);
    }
}
