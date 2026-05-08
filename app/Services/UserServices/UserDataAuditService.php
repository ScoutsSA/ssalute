<?php

namespace App\Services\UserServices;

use App\Providers\AppServiceProvider;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use stdClass;
use Throwable;

class UserDataAuditService
{
    public const CATEGORY_MAIN = 'main';

    public const CATEGORY_NOTIFICATION = 'notification';

    public const CATEGORY_LOG = 'log';

    /**
     * Polymorphic morph types that represent system users. Used as an explicit
     * allowlist when scanning `*_type`/`*_id` morph columns — substring matches
     * like LIKE '%User%' would also catch `SystemUserType`, `SystemUsersOtherRole`,
     * etc., which are not user references and would be silently corrupted.
     *
     * If a future model also represents a user, add its FQCN here.
     *
     * @var list<class-string>
     */
    public const USER_MORPH_TYPES = [
        \App\Models\SystemUser::class,
    ];

    /** @var array<string, array<int, ?string>> */
    private array $lookupCache = [];

    /**
     * Map of table name to the columns that may hold a system_users.id.
     * Casing matches the legacy schema (column names are case-insensitive in MySQL).
     *
     * @return array<string, list<string>>
     */
    public static function tables(): array
    {
        return [
            'system_users' => ['passwordChangedBy', 'createdby', 'modifiedby', 'deactivatedBy'],

            'admin_404_pages' => ['userID'],

            'advancement_cubs' => ['userID', 'createdby', 'modifiedby'],
            'advancement_documents' => ['userID', 'createdby', 'modifiedby'],
            'advancement_meerkats' => ['userID', 'createdby', 'modifiedby'],
            'advancement_notes' => ['userID', 'createdby', 'modifiedby'],
            'advancement_photos' => ['userID', 'createdby', 'modifiedby'],
            'advancement_rovers' => ['userID', 'createdby', 'modifiedby'],
            'advancement_scouters' => ['scouterID', 'createdby', 'modifiedby'],
            'advancement_scouts' => ['userID', 'createdby', 'modifiedby', 'approvedBy'],

            'ams_adult_leader_moves' => ['userID', 'createdby'],
            'ams_award_applications' => ['userID', 'createdby', 'modifiedby', 'awardedBy', 'declinedBy'],
            'ams_award_info' => ['userID', 'createdby', 'modifiedby'],
            'ams_award_types' => ['createdby', 'modifiedby'],
            'ams_charge_info' => ['userID', 'createdby', 'modifiedby'],
            'ams_charge_types' => ['createdby', 'modifiedby'],
            'ams_criminal_check' => ['userID', 'createdby', 'modifiedby'],
            'ams_disciplinary_info' => ['userID', 'createdby', 'modifiedby'],
            'ams_documents' => ['userID', 'createdby', 'modifiedby'],
            'ams_documents_groups' => ['createdby', 'modifiedby'],
            'ams_past_service_info' => ['userID', 'createdby', 'modifiedby'],
            'ams_police_clearance' => ['userID', 'createdby', 'modifiedby'],
            'ams_resign_leader' => ['userID', 'createdby', 'modifiedby'],
            'ams_retire_leader' => ['userID', 'createdby', 'modifiedby'],
            'ams_suspend_leader' => ['userID', 'unsuspendedby', 'createdby', 'modifiedby'],
            'ams_terminate_leader' => ['userID', 'createdby', 'modifiedby'],
            'ams_warrant_applications' => ['userID', 'createdby', 'modifiedby', 'awardedBy', 'declinedBy'],
            'ams_warrant_extensions' => ['userID', 'createdby', 'modifiedby'],
            'ams_warrant_info' => ['userID', 'createdby', 'modifiedby'],
            'ams_warrant_types' => ['createdby', 'modifiedby'],

            'ams_training_courses' => ['createdby', 'modifiedby'],
            'ams_training_courses_annual' => ['createdby', 'modifiedby'],
            'ams_training_courses_annual_attendance' => ['userID', 'createdby', 'modifiedby'],
            'ams_training_courses_annual_bookings' => ['userID', 'createdby', 'modifiedby'],
            'ams_training_courses_annual_bookings_notes' => ['userID', 'createdby', 'modifiedby'],
            'ams_training_courses_annual_bookings_tracking' => ['userID', 'createdby'],
            'ams_training_courses_annual_dates' => ['createdby', 'modifiedby'],
            'ams_training_courses_annual_lecturers' => ['createdby', 'modifiedby'],
            'ams_training_courses_annual_warrants_available' => ['createdby', 'modifiedby'],
            'ams_training_locations' => ['createdby', 'modifiedby'],
            'ams_training_past' => ['userID', 'createdby', 'modifiedby', 'validatedby'],
            'ams_training_past_types' => ['createdby', 'modifiedby'],

            'api_keys' => ['issuedToUserID'],

            'badges_cubs' => ['userID', 'createdby', 'modifiedby'],
            'badges_documents' => ['userID', 'createdby', 'modifiedby'],
            'badges_meerkats' => ['userID', 'createdby', 'modifiedby'],
            'badges_notes' => ['userID', 'createdby', 'modifiedby'],
            'badges_photos' => ['userID', 'createdby', 'modifiedby'],
            'badges_rovers' => ['userID', 'createdby', 'modifiedby', 'approvedBy'],
            'badges_scouts' => ['userID', 'createdby', 'modifiedby', 'approvedBy'],

            'census_documents' => ['createdby'],

            'commerce_cart' => ['userID', 'createdby', 'modifiedby'],
            'commerce_delivery_address' => ['userID', 'createdby', 'modifiedby'],
            'commerce_group_fees' => ['userID', 'createdby'],
            'commerce_orders' => ['userID', 'createdby'],
            'commerce_orders_details' => ['userID'],
            'commerce_payfast_transactions' => ['userID'],
            'commerce_products' => ['createdby', 'modifiedby'],
            'commerce_products_images' => ['createdby', 'modifiedby'],
            'commerce_products_reviews' => ['userID', 'createdby', 'modifiedby'],
            'commerce_search_queries' => ['userID'],
            'commerce_shoppers_logins' => ['userID'],
            'commerce_wallet' => ['userID'],
            'commerce_wish_list' => ['userID', 'createdby', 'modifiedby'],

            'directory_professional' => ['approvedBy', 'declinedBy', 'createdby', 'modifiedby'],
            'directory_professional_likes' => ['createdby'],
            'directory_professional_reviews' => ['approvedBy', 'declinedby', 'createdby', 'modifiedby'],

            'districts' => ['createdby', 'modifiedby'],
            'districts_super' => ['createdby', 'modifiedby'],

            'error_logging' => ['userID'],

            'event_booking_setup_changes' => ['createdby'],
            'event_competition_score_adjudication' => ['createdby', 'modifiedby'],
            'event_competitions_answers' => ['createdby', 'modifiedby'],
            'event_competitions_finances_invoices' => ['createdby', 'modifiedby'],
            'event_competitions_finances_payments' => ['createdby', 'modifiedby'],
            'event_competitions_gps' => ['createdby', 'modifiedby'],
            'event_competitions_groups_attending' => ['createdby', 'modifiedby'],
            'event_competitions_groups_participating' => ['createdby', 'modifiedby'],
            'event_competitions_internal_competitions' => ['createdby', 'modifiedby'],
            'event_competitions_judges' => ['userID', 'createdby', 'modifiedby'],
            'event_competitions_location_logging' => ['userID'],
            'event_competitions_questions' => ['createdby', 'modifiedby'],
            'event_competitions_scoring' => ['createdby', 'modifiedBy'],
            'event_competitions_scoring_areas' => ['createdby', 'modifiedby'],
            'event_competitions_scoring_dnp' => ['createdby', 'modifiedby'],
            'event_competitions_scoring_sheets' => ['createdby', 'modifiedby'],
            'event_competitions_scoring_sheets_headings' => ['createdby', 'modifiedBy'],

            'event_user_booking' => ['userID', 'createdby', 'modifiedby'],
            'event_user_booking_accomodation' => ['createdby', 'modifiedby'],
            'event_user_booking_credit_notes' => ['userID', 'createdby', 'modifiedby'],
            'event_user_booking_invoices' => ['userID', 'createdby', 'modifiedby'],
            'event_user_booking_notes' => ['userID', 'createdby', 'modifiedby'],
            'event_user_booking_other_options' => ['createdby', 'modifiedby'],
            'event_user_booking_patrol_allocation' => ['userID', 'createdby', 'modifiedby'],
            'event_user_booking_patrols' => ['createdby', 'modifiedby'],
            'event_user_booking_payments' => ['userID', 'createdby', 'modifiedby'],
            'event_user_booking_pops' => ['userID', 'createdby', 'modifiedby'],
            'event_user_booking_roles' => ['createdby', 'modifiedby'],
            'event_user_booking_transport' => ['createdby', 'modifiedby'],

            'forms_aam_requests' => ['actioned_by'],

            'group_account_transfers_notes' => ['createdby', 'modifiedby'],
            'group_accounts' => ['createdby', 'modifiedby'],
            'group_accounts_transfers' => ['createdby', 'modifiedby'],
            'group_advancements_in_events' => ['createdby', 'modifiedby'],
            'group_advancements_in_programs' => ['createdby', 'modifiedby'],
            'group_attendance' => ['userId', 'createdby', 'modifiedby'],
            'group_badges_in_events' => ['createdby', 'modifiedby'],
            'group_badges_in_programs' => ['createdby', 'modifiedby'],
            'group_committee' => ['userID', 'createdby', 'modifiedby'],
            'group_council' => ['userID', 'createdby', 'modifiedby'],
            'group_cub_packs' => ['createdby', 'modifiedby'],
            'group_cubs_sixes_names' => ['createdby'],
            'group_documents' => ['createdby', 'modifiedby'],
            'group_equipment' => ['createdby', 'modifiedby'],
            'group_equipment_store' => ['createdby', 'modifiedby'],
            'group_event_documents' => ['createdby', 'modifiedby'],
            'group_events' => ['createdby', 'modifiedby'],
            'group_events_attending' => ['userID', 'createdby', 'modifiedby'],
            'group_financial_annual_invoice_discounts' => ['createdby', 'modifiedby'],
            'group_financial_credit_notes' => ['createdby', 'modifiedby'],
            'group_financial_credit_notes_items' => ['createdby', 'modifiedby'],
            'group_financial_fee_types' => ['createdby', 'modifiedby'],
            'group_financial_fees' => ['createdby', 'modifiedby'],
            'group_financial_invoices' => ['createdby', 'modifiedby'],
            'group_financial_invoices_emailed' => ['createdby'],
            'group_financial_invoices_items' => ['createdby', 'modifiedby'],
            'group_financial_payments_made' => ['createdby', 'modifiedby'],
            'group_financial_years' => ['createdby', 'modifiedby'],
            'group_meerkat_dens' => ['createdby', 'modifiedby'],
            'group_meerkats_patrol_names' => ['createdby'],
            'group_newsletters' => ['createdby', 'modifiedby'],
            'group_parents_committee_minutes' => ['createdby', 'modifiedby'],
            'group_programs' => ['createdby', 'modifiedby', 'sharedby'],
            'group_programs_documents' => ['createdby', 'modifiedby'],
            'group_programs_online_tasks' => ['createdby', 'modifiedby'],
            'group_programs_online_tasks_completion' => ['userID', 'createdby', 'modifiedby'],
            'group_programs_online_tasks_documents' => ['userID', 'createdby', 'modifiedby'],
            'group_programs_online_tasks_images' => ['userID', 'createdby', 'modifiedby'],
            'group_programs_online_tasks_notes' => ['userID', 'createdby', 'modifiedby'],
            'group_programs_online_tasks_penalty' => ['userID', 'createdby', 'modifiedby'],
            'group_programs_online_working_on' => ['userID', 'createdby'],
            'group_rover_crews' => ['createdby', 'modifiedby'],
            'group_rovers_patrol_names' => ['createdby'],
            'group_scout_troops' => ['createdby', 'modifiedby'],
            'group_scouts_charges' => ['createdby', 'modifiedby'],
            'group_scouts_patrol_names' => ['createdby'],
            'group_send_logon_details' => ['userID', 'createdby'],
            'group_star_awards' => ['createdby', 'modifiedby'],
            'group_user_picture_changes' => ['userID', 'createdby'],
            'group_weekly_emails_emailed' => ['userID', 'createdby'],
            'group_youth_charges' => ['userID', 'createdby', 'modifiedby'],

            'groups' => ['createdby', 'modifiedby', 'groupLastUpdatedBy'],
            'groups_entsha_move' => ['createdby'],
            'groups_multi' => ['createdby', 'modifiedby'],
            'groups_property' => ['createdby', 'modifiedby'],
            'groups_property_updates' => ['updatedby'],

            'info_sharing' => ['approvedby', 'declinedby', 'createdby', 'modifiedby'],
            'info_sharing_likes' => ['createdby'],
            'info_sharing_reviews' => ['createdby', 'approvedby', 'declinedby'],

            'jamboree_adult_allocations' => ['userID', 'createdby', 'modifiedby'],
            'jamboree_application' => ['userID', 'applicationApprovedBy', 'declinedPositionBy', 'createdby', 'modifiedby'],
            'jamboree_bus_info' => ['createdby', 'modifiedby'],
            'jamboree_buses_users' => ['userID', 'createdby', 'modifiedby'],
            'jamboree_core_team' => ['userID', 'createdby'],
            'jamboree_eoi' => ['userID', 'createdby', 'modifiedby'],
            'jamboree_expr_of_interest' => ['userID', 'parentID', 'offeredPositionBy', 'declinedPositionBy'],
            'jamboree_generated_pdfs' => ['userID', 'createdby'],
            'jamboree_initial_thoughts' => ['userID', 'modifiedby'],
            'jamboree_invoices' => ['userID', 'createdby', 'modifiedby'],
            'jamboree_invoices_items' => ['createdby', 'modifiedby'],
            'jamboree_payments' => ['userID', 'createdby', 'modifiedby'],
            'jamboree_position_offered' => ['userID', 'parentID', 'offeredPositionBy'],
            'jamboree_scouters' => ['userID'],
            'jamboree_troop_patrol_allocations' => ['userID', 'createdby', 'modifiedby'],

            'membership_certificates' => ['user_id'],

            'notifications' => ['userID', 'createdby'],
            'notifications_archive' => ['userID', 'createdby'],

            'projects' => ['approvedby', 'declinedby', 'createdby', 'modifiedby'],
            'projects_supported' => ['createdby', 'modifiedby'],

            'scouter_reviews' => ['userID', 'approvedby', 'declinedby', 'createdby', 'modifiedby'],
            'scouter_reviews_likes' => ['createdby'],
            'star_awards' => ['scouterAskedAwardUserID', 'nptmAskedAwardUserID', 'rtcRecommendedUserID', 'chairAwardedUserID'],
            'star_awards_notes' => ['createdby', 'modifiedby'],

            // sd_articles.createdby is varchar(255) and holds free text (e.g. author names),
            // not user IDs. Excluded from the audit/merge map.

            'services_purchased' => ['associatedToGroupBy'],
            'services_purchased_spreadsheets_received' => ['addedBy'],
            'services_purchased_spreadsheets_sent' => ['sentBy'],

            'support_chats' => ['userID'],
            'support_chats_start' => ['userID', 'closedBy'],

            'system_advancement_scouts_second_entsha_badges' => ['createdby', 'modifiedby'],
            'system_badge_cubs_first' => ['createdby', 'modifiedby'],
            'system_badge_cubs_second' => ['createdby', 'modifiedby'],
            'system_badge_meerkats_first' => ['createdby', 'modifiedby'],
            'system_badge_meerkats_second' => ['createdby', 'modifiedby'],
            'system_badge_rovers_first' => ['createdby', 'modifiedby'],
            'system_badge_rovers_second' => ['createdby', 'modifiedby'],
            'system_badge_scouts_first' => ['createdby', 'modifiedby'],
            'system_badge_scouts_second' => ['createdby', 'modifiedby'],
            'system_committee_types' => ['createdby'],
            'system_council_types' => ['createdby'],
            'system_group_management_level' => ['createdby'],
            'system_program_types_cubs' => ['createdby'],
            'system_program_types_meerkats' => ['createdby'],
            'system_program_types_rovers' => ['createdby'],
            'system_program_types_scouts' => ['createdby'],
            'system_roadmap_little' => ['createdby', 'modifiedby'],
            'system_user_logging' => ['userID'],
            'system_user_types' => ['createdby', 'modifiedby'],

            'system_users_email_verifications' => ['userID'],
            'system_users_emergency_contacts' => ['userID', 'createdby', 'modifiedby'],
            'system_users_fingerprint' => ['userID'],
            'system_users_forced_logouts' => ['userID'],
            'system_users_form29' => ['userID', 'DSDResponseBy', 'createdby', 'modifiedby'],
            'system_users_other_roles' => ['userID', 'createdby', 'modifiedby'],

            'telegram_ban_count' => ['userID'],
            'telegram_currently_chatting' => ['systemUserID', 'chattingToUserID'],
            'telegram_messages' => ['userID', 'markedReadBy'],
            'telegram_sent_human_message' => ['userID'],
            'telegram_usernames' => ['userID'],

            'wsm16_expression' => ['userID', 'createdby', 'modifiedby'],
        ];
    }

    /**
     * Polymorphic relationships where the morph type may resolve to a User model.
     *
     * @return array<string, list<array{type: string, id: string}>>
     */
    public static function polymorphicTables(): array
    {
        return [
            'ssalute_audits' => [
                ['type' => 'user_type', 'id' => 'user_id'],
                ['type' => 'auditable_type', 'id' => 'auditable_id'],
            ],
            'ssalute_notifications' => [
                ['type' => 'notifiable_type', 'id' => 'notifiable_id'],
            ],
        ];
    }

    /**
     * Categorise a table for display grouping.
     */
    public static function tableCategory(string $table): string
    {
        return self::categoryMap()[$table] ?? self::CATEGORY_MAIN;
    }

    /**
     * @return array<string, string>
     */
    private static function categoryMap(): array
    {
        return [
            'admin_404_pages' => self::CATEGORY_LOG,
            'error_logging' => self::CATEGORY_LOG,
            'event_booking_setup_changes' => self::CATEGORY_LOG,
            'event_competitions_location_logging' => self::CATEGORY_LOG,
            'group_financial_invoices_emailed' => self::CATEGORY_LOG,
            'group_send_logon_details' => self::CATEGORY_LOG,
            'group_user_picture_changes' => self::CATEGORY_LOG,
            'group_weekly_emails_emailed' => self::CATEGORY_LOG,
            'ssalute_audits' => self::CATEGORY_LOG,
            'system_user_logging' => self::CATEGORY_LOG,
            'system_users_fingerprint' => self::CATEGORY_LOG,
            'system_users_forced_logouts' => self::CATEGORY_LOG,

            'notifications' => self::CATEGORY_NOTIFICATION,
            'notifications_archive' => self::CATEGORY_NOTIFICATION,
            'ssalute_notifications' => self::CATEGORY_NOTIFICATION,
            'support_chats' => self::CATEGORY_NOTIFICATION,
            'support_chats_start' => self::CATEGORY_NOTIFICATION,
            'system_users_email_verifications' => self::CATEGORY_NOTIFICATION,
            'telegram_ban_count' => self::CATEGORY_NOTIFICATION,
            'telegram_currently_chatting' => self::CATEGORY_NOTIFICATION,
            'telegram_messages' => self::CATEGORY_NOTIFICATION,
            'telegram_sent_human_message' => self::CATEGORY_NOTIFICATION,
            'telegram_usernames' => self::CATEGORY_NOTIFICATION,
        ];
    }

    /**
     * Join non-empty parts with " / ".
     *
     * @param  list<?string>  $parts
     */
    private static function join(array $parts): string
    {
        return implode(' / ', array_filter(
            array_map(fn ($v) => $v === null ? null : trim((string) $v), $parts),
            fn ($v) => $v !== null && $v !== '',
        ));
    }

    private static function shortDate(mixed $value): string
    {
        if ($value === null || $value === '' || $value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
            return '';
        }

        try {
            return \Illuminate\Support\Carbon::parse((string) $value)->format('Y-m-d');
        } catch (Throwable) {
            return (string) $value;
        }
    }

    private static function truncate(string $value, int $length): string
    {
        return strlen($value) <= $length ? $value : substr($value, 0, $length - 1) . '…';
    }

    /**
     * @return array<int, array{table: string, category: string, columns: list<string>, count: int, rows: list<array{id: int, label: string}>, has_more: bool, polymorphic: bool, error: ?string}>
     */
    public function audit(int $userId): array
    {
        $connection = $this->connection();
        $sampleLimit = 50;
        $results = [];

        $userRow = $this->fetchUser($connection, $userId);
        if ($userRow !== null) {
            $results[] = [
                'table' => 'system_users',
                'category' => self::CATEGORY_MAIN,
                'columns' => ['id'],
                'count' => 1,
                'rows' => [[
                    'id' => $userId,
                    'label' => trim(($userRow->first_name ?? '') . ' ' . ($userRow->surname ?? '')) . ' (' . ($userRow->username ?? '') . ')',
                ]],
                'has_more' => false,
                'polymorphic' => false,
                'error' => null,
            ];
        }

        foreach (static::tables() as $table => $columns) {
            $result = $this->auditTable($connection, $table, $columns, $userId, $sampleLimit);
            if ($result !== null) {
                $results[] = $result;
            }
        }

        foreach (static::polymorphicTables() as $table => $pairs) {
            $result = $this->auditPolymorphicTable($connection, $table, $pairs, $userId, $sampleLimit);
            if ($result !== null) {
                $results[] = $result;
            }
        }

        return $results;
    }

    /**
     * Build a Filament Infolist schema (array of Schema components) for the audit.
     * Use this from Filament UI; for non-UI callers use audit() directly.
     *
     * @return list<Component>
     */
    public function getAuditAsFilamentInfoList(int $userId): array
    {
        $results = $this->audit($userId);

        $sectionTitles = [
            self::CATEGORY_MAIN => 'Records',
            self::CATEGORY_NOTIFICATION => 'Notifications & Messaging',
            self::CATEGORY_LOG => 'Logs & Tracking',
        ];

        $grouped = [
            self::CATEGORY_MAIN => [],
            self::CATEGORY_NOTIFICATION => [],
            self::CATEGORY_LOG => [],
        ];
        foreach ($results as $row) {
            $grouped[$row['category']][] = $row;
        }

        $totalRows = array_sum(array_column($results, 'count'));
        $totalTables = count($results);

        if ($totalTables === 0) {
            return [
                TextEntry::make('audit_empty')
                    ->hiddenLabel()
                    ->state('No references found for this user across any audited table.')
                    ->color('success'),
            ];
        }

        $tabs = [];
        foreach ($grouped as $category => $rows) {
            if ($rows === []) {
                continue;
            }

            $sectionRowCount = array_sum(array_column($rows, 'count'));
            $tabs[] = Tab::make($sectionTitles[$category])
                ->badge((string) $sectionRowCount)
                ->schema(array_map(
                    fn (array $tableResult): Component => $this->buildTableSection($tableResult),
                    $rows,
                ));
        }

        return [
            TextEntry::make('audit_summary')
                ->hiddenLabel()
                ->state(sprintf(
                    '%d %s across %d %s for user #%d.',
                    $totalRows,
                    Str::plural('row', $totalRows),
                    $totalTables,
                    Str::plural('table', $totalTables),
                    $userId,
                ))
                ->color('gray'),
            Tabs::make('audit_tabs')->tabs($tabs),
        ];
    }

    /**
     * Resolve a related row's `name` column (or fallback) by id, with per-request caching.
     */
    public function lookupName(string $table, ?int $id, string $column = 'name'): ?string
    {
        if ($id === null || $id === 0) {
            return null;
        }

        if (! isset($this->lookupCache[$table])) {
            $this->lookupCache[$table] = [];
        }

        if (array_key_exists($id, $this->lookupCache[$table])) {
            return $this->lookupCache[$table][$id];
        }

        try {
            $value = $this->connection()->table($table)->where('id', $id)->value($column);
        } catch (Throwable) {
            $value = null;
        }

        return $this->lookupCache[$table][$id] = ($value !== null ? (string) $value : null);
    }

    /**
     * @param  array{table: string, category: string, columns: list<string>, count: int, rows: list<array{id: int, label: string}>, has_more: bool, polymorphic: bool, error: ?string}  $tableResult
     */
    private function buildTableSection(array $tableResult): Section
    {
        $description = sprintf(
            '%d %s%s · via %s',
            $tableResult['count'],
            Str::plural('row', $tableResult['count']),
            $tableResult['has_more'] ? '+' : '',
            implode(', ', $tableResult['columns']),
        );

        if ($tableResult['polymorphic']) {
            $description .= ' (polymorphic)';
        }

        $section = Section::make($tableResult['table'])
            ->description($description)
            ->collapsible()
            ->collapsed();

        if ($tableResult['error'] !== null) {
            return $section->schema([
                TextEntry::make('error_' . $tableResult['table'])
                    ->hiddenLabel()
                    ->state('Error: ' . $tableResult['error'])
                    ->color('warning'),
            ]);
        }

        $rowsState = array_map(fn (array $entry): array => [
            'id' => '#' . $entry['id'],
            'label' => $entry['label'] !== '' ? $entry['label'] : '—',
        ], $tableResult['rows']);

        if ($tableResult['has_more']) {
            $rowsState[] = ['id' => '…', 'label' => 'and more'];
        }

        return $section->schema([
            RepeatableEntry::make('rows_' . md5($tableResult['table']))
                ->hiddenLabel()
                ->state($rowsState)
                ->schema([
                    TextEntry::make('id')
                        ->hiddenLabel()
                        ->color('gray')
                        ->columnSpan(1),
                    TextEntry::make('label')
                        ->hiddenLabel()
                        ->columnSpan(5),
                ])
                ->columns(6)
                ->contained(false),
        ]);
    }

    private function connection(): ConnectionInterface
    {
        return DB::connection(AppServiceProvider::DB_SD_CORE);
    }

    private function fetchUser(ConnectionInterface $connection, int $userId): ?stdClass
    {
        try {
            return $connection->table('system_users')->where('id', $userId)->first();
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * @param  list<string>  $userColumns
     * @return ?array{table: string, category: string, columns: list<string>, count: int, rows: list<array{id: int, label: string}>, has_more: bool, polymorphic: bool, error: ?string}
     */
    private function auditTable(ConnectionInterface $connection, string $table, array $userColumns, int $userId, int $sampleLimit): ?array
    {
        $context = $this->contextSpec($table);
        $contextColumns = $context['select'] ?? [];

        $whereParts = [];
        $bindings = [];
        foreach ($userColumns as $column) {
            $whereParts[] = "`{$column}` = ?";
            $bindings[] = $userId;
        }
        $whereSql = implode(' OR ', $whereParts);

        [$rows, $error, $usedFallback] = $this->fetchRows($connection, $table, $whereSql, $bindings, $contextColumns, $sampleLimit + 1);

        if ($error !== null) {
            return [
                'table' => $table,
                'category' => self::tableCategory($table),
                'columns' => $userColumns,
                'count' => 0,
                'rows' => [],
                'has_more' => false,
                'polymorphic' => false,
                'error' => $error,
            ];
        }

        if ($rows === []) {
            return null;
        }

        $hasMore = count($rows) > $sampleLimit;
        $rows = array_slice($rows, 0, $sampleLimit);

        $formatter = $context['format'] ?? null;
        $labelled = array_map(fn (stdClass $row): array => [
            'id' => (int) $row->id,
            'label' => ($formatter !== null && ! $usedFallback)
                ? (string) $formatter($row, $this)
                : $this->defaultLabel($row, $usedFallback ? [] : $contextColumns),
        ], $rows);

        return [
            'table' => $table,
            'category' => self::tableCategory($table),
            'columns' => $userColumns,
            'count' => count($labelled),
            'rows' => $labelled,
            'has_more' => $hasMore,
            'polymorphic' => false,
            'error' => null,
        ];
    }

    /**
     * @param  list<array{type: string, id: string}>  $pairs
     * @return ?array{table: string, category: string, columns: list<string>, count: int, rows: list<array{id: int, label: string}>, has_more: bool, polymorphic: bool, error: ?string}
     */
    private function auditPolymorphicTable(ConnectionInterface $connection, string $table, array $pairs, int $userId, int $sampleLimit): ?array
    {
        $typePlaceholders = implode(',', array_fill(0, count(self::USER_MORPH_TYPES), '?'));
        $whereParts = [];
        $bindings = [];
        $columns = [];
        foreach ($pairs as $pair) {
            $whereParts[] = "(`{$pair['type']}` IN ({$typePlaceholders}) AND `{$pair['id']}` = ?)";
            foreach (self::USER_MORPH_TYPES as $morphType) {
                $bindings[] = $morphType;
            }
            $bindings[] = $userId;
            $columns[] = $pair['type'];
            $columns[] = $pair['id'];
        }

        $context = $this->contextSpec($table);
        $contextColumns = $context['select'] ?? [];
        $whereSql = implode(' OR ', $whereParts);

        [$rows, $error, $usedFallback] = $this->fetchRows($connection, $table, $whereSql, $bindings, $contextColumns, $sampleLimit + 1);

        if ($error !== null) {
            return [
                'table' => $table,
                'category' => self::tableCategory($table),
                'columns' => $columns,
                'count' => 0,
                'rows' => [],
                'has_more' => false,
                'polymorphic' => true,
                'error' => $error,
            ];
        }

        if ($rows === []) {
            return null;
        }

        $hasMore = count($rows) > $sampleLimit;
        $rows = array_slice($rows, 0, $sampleLimit);

        $formatter = $context['format'] ?? null;
        $labelled = array_map(fn (stdClass $row): array => [
            'id' => (int) $row->id,
            'label' => ($formatter !== null && ! $usedFallback)
                ? (string) $formatter($row, $this)
                : $this->defaultLabel($row, $usedFallback ? [] : $contextColumns),
        ], $rows);

        return [
            'table' => $table,
            'category' => self::tableCategory($table),
            'columns' => $columns,
            'count' => count($labelled),
            'rows' => $labelled,
            'has_more' => $hasMore,
            'polymorphic' => true,
            'error' => null,
        ];
    }

    /**
     * Fetch rows for a table. If the configured context columns are missing on the
     * actual table, retries with id only. Returns [rows, error, usedFallback].
     *
     * @param  list<mixed>  $bindings
     * @param  list<string>  $contextColumns
     * @return array{0: list<stdClass>, 1: ?string, 2: bool}
     */
    private function fetchRows(ConnectionInterface $connection, string $table, string $whereSql, array $bindings, array $contextColumns, int $limit): array
    {
        $select = array_values(array_unique(array_merge(['id'], $contextColumns)));

        try {
            $rows = $connection
                ->table($table)
                ->whereRaw($whereSql, $bindings)
                ->limit($limit)
                ->get($select)
                ->all();

            return [$rows, null, false];
        } catch (Throwable $exception) {
            if (! $this->isMissingColumnError($exception) || $contextColumns === []) {
                return [[], $exception->getMessage(), false];
            }
        }

        try {
            $rows = $connection
                ->table($table)
                ->whereRaw($whereSql, $bindings)
                ->limit($limit)
                ->get(['id'])
                ->all();

            return [$rows, null, true];
        } catch (Throwable $exception) {
            return [[], $exception->getMessage(), false];
        }
    }

    private function isMissingColumnError(Throwable $exception): bool
    {
        return str_contains($exception->getMessage(), '1054')
            || str_contains($exception->getMessage(), 'Unknown column');
    }

    /**
     * Build a default label for tables without an explicit formatter.
     *
     * @param  list<string>  $columns
     */
    private function defaultLabel(stdClass $row, array $columns): string
    {
        $parts = [];
        foreach ($columns as $column) {
            $value = $row->{$column} ?? null;
            if ($value === null || $value === '') {
                continue;
            }
            $parts[] = (string) $value;
        }

        return implode(' / ', $parts);
    }

    /**
     * Per-table context specification for richer labels.
     *
     * @return array{select?: list<string>, format?: callable(stdClass, self): string}
     */
    private function contextSpec(string $table): array
    {
        $specs = $this->contextSpecs();

        return $specs[$table] ?? [];
    }

    /**
     * @return array<string, array{select: list<string>, format?: callable(stdClass, self): string}>
     */
    private function contextSpecs(): array
    {
        return [
            'system_users_other_roles' => [
                'select' => ['roleID', 'groupID', 'districtID', 'regionID', 'active', 'retired', 'resigned', 'suspended'],
                'format' => function (stdClass $row, self $service): string {
                    $role = $service->lookupName('system_user_types', (int) ($row->roleID ?? 0)) ?? 'Unknown role';
                    $scope = $service->lookupName('groups', (int) ($row->groupID ?? 0))
                        ?? $service->lookupName('districts', (int) ($row->districtID ?? 0))
                        ?? $service->lookupName('regions', (int) ($row->regionID ?? 0));
                    $status = match (true) {
                        (int) ($row->retired ?? 0) === 1 => 'retired',
                        (int) ($row->resigned ?? 0) === 1 => 'resigned',
                        (int) ($row->suspended ?? 0) === 1 => 'suspended',
                        (int) ($row->active ?? 0) === 1 => 'active',
                        default => 'inactive',
                    };

                    return self::join([$role, $scope, $status]);
                },
            ],

            'ams_documents' => [
                'select' => ['description', 'PDFLocation', 'created', 'active'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->description ?: ($row->PDFLocation ? basename((string) $row->PDFLocation) : null),
                    self::shortDate($row->created ?? null),
                    (int) ($row->active ?? 0) === 0 ? 'inactive' : null,
                ]),
            ],

            'ams_award_info' => [
                'select' => ['awardTypeID', 'awardDate', 'active'],
                'format' => fn (stdClass $row, self $service): string => self::join([
                    $service->lookupName('ams_award_types', (int) ($row->awardTypeID ?? 0)) ?? 'Award',
                    self::shortDate($row->awardDate ?? null),
                    (int) ($row->active ?? 0) === 0 ? 'inactive' : null,
                ]),
            ],
            'ams_award_applications' => [
                'select' => ['awardTypeID', 'created', 'active'],
                'format' => fn (stdClass $row, self $service): string => self::join([
                    $service->lookupName('ams_award_types', (int) ($row->awardTypeID ?? 0)) ?? 'Award application',
                    self::shortDate($row->created ?? null),
                ]),
            ],

            'ams_warrant_info' => [
                'select' => ['warrantTypeID', 'warrantNr', 'warrantName', 'issueDate', 'expireDate', 'active'],
                'format' => fn (stdClass $row, self $service): string => self::join([
                    $row->warrantName ?: ($service->lookupName('ams_warrant_types', (int) ($row->warrantTypeID ?? 0)) ?? 'Warrant'),
                    $row->warrantNr ?: null,
                    $row->issueDate ? 'issued ' . self::shortDate($row->issueDate) : null,
                    $row->expireDate ? 'expires ' . self::shortDate($row->expireDate) : null,
                ]),
            ],
            'ams_warrant_applications' => [
                'select' => ['warrantTypeID', 'created'],
                'format' => fn (stdClass $row, self $service): string => self::join([
                    $service->lookupName('ams_warrant_types', (int) ($row->warrantTypeID ?? 0)) ?? 'Warrant application',
                    self::shortDate($row->created ?? null),
                ]),
            ],
            'ams_warrant_extensions' => [
                'select' => ['created'],
                'format' => fn (stdClass $row): string => self::shortDate($row->created ?? null),
            ],

            'ams_resign_leader' => [
                'select' => ['resignDate'],
                'format' => fn (stdClass $row): string => 'Resigned ' . self::shortDate($row->resignDate ?? null),
            ],
            'ams_retire_leader' => [
                'select' => ['retiredDate'],
                'format' => fn (stdClass $row): string => 'Retired ' . self::shortDate($row->retiredDate ?? null),
            ],
            'ams_suspend_leader' => [
                'select' => ['suspendDate', 'unsuspendDate'],
                'format' => fn (stdClass $row): string => self::join([
                    'Suspended ' . self::shortDate($row->suspendDate ?? null),
                    $row->unsuspendDate ? 'lifted ' . self::shortDate($row->unsuspendDate) : 'still active',
                ]),
            ],
            'ams_terminate_leader' => [
                'select' => ['terminateDate'],
                'format' => fn (stdClass $row): string => 'Terminated ' . self::shortDate($row->terminateDate ?? null),
            ],
            'ams_adult_leader_moves' => [
                'select' => ['effectiveDate', 'fromPosition', 'ToPosition'],
                'format' => fn (stdClass $row, self $service): string => self::join([
                    $service->lookupName('system_user_types', (int) ($row->fromPosition ?? 0)) ?? '?',
                    '→',
                    $service->lookupName('system_user_types', (int) ($row->ToPosition ?? 0)) ?? '?',
                    self::shortDate($row->effectiveDate ?? null),
                ]),
            ],

            'ams_criminal_check' => [
                'select' => ['criminalType', 'created'],
                'format' => fn (stdClass $row): string => self::join([
                    self::shortDate($row->created ?? null),
                ]),
            ],
            'ams_police_clearance' => [
                'select' => ['result', 'dateDone', 'active'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->result ?? null,
                    'done ' . self::shortDate($row->dateDone ?? null),
                    (int) ($row->active ?? 0) === 0 ? 'inactive' : null,
                ]),
            ],
            'ams_past_service_info' => [
                'select' => ['startDate', 'endDate', 'otherGroupName'],
                'format' => fn (stdClass $row): string => self::join([
                    self::shortDate($row->startDate ?? null) . ' → ' . self::shortDate($row->endDate ?? null),
                    $row->otherGroupName ?? null,
                ]),
            ],
            'ams_training_past' => [
                'select' => ['courseName', 'completionDate'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->courseName ?? null,
                    self::shortDate($row->completionDate ?? null),
                ]),
            ],

            'advancement_scouts' => [
                'select' => ['advancementID', 'advancementDate', 'active'],
                'format' => fn (stdClass $row, self $service): string => self::join([
                    $service->lookupName('system_advancement_scouts_second', (int) ($row->advancementID ?? 0)) ?? 'Advancement',
                    self::shortDate($row->advancementDate ?? null),
                ]),
            ],
            'advancement_cubs' => [
                'select' => ['advancementDate'],
                'format' => fn (stdClass $row): string => self::shortDate($row->advancementDate ?? null),
            ],
            'advancement_meerkats' => [
                'select' => ['advancementDate'],
                'format' => fn (stdClass $row): string => self::shortDate($row->advancementDate ?? null),
            ],
            'advancement_rovers' => [
                'select' => ['advancementDate'],
                'format' => fn (stdClass $row): string => self::shortDate($row->advancementDate ?? null),
            ],

            'badges_scouts' => [
                'select' => ['firstID', 'secondID', 'badgeDate'],
                'format' => fn (stdClass $row, self $service): string => self::join([
                    $service->lookupName('system_badge_scouts_first', (int) ($row->firstID ?? 0)) ?? 'Badge',
                    self::shortDate($row->badgeDate ?? null),
                ]),
            ],

            'commerce_orders' => [
                'select' => ['status', 'created'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->status ?? null,
                    self::shortDate($row->created ?? null),
                ]),
            ],
            'commerce_cart' => [
                'select' => ['created'],
                'format' => fn (stdClass $row): string => self::shortDate($row->created ?? null),
            ],

            'event_user_booking' => [
                'select' => ['eventID', 'created', 'active'],
                'format' => fn (stdClass $row): string => self::join([
                    'event #' . ((int) ($row->eventID ?? 0)),
                    self::shortDate($row->created ?? null),
                ]),
            ],

            'jamboree_application' => [
                'select' => ['created', 'applicationApproved', 'declinedPosition'],
                'format' => fn (stdClass $row): string => self::join([
                    self::shortDate($row->created ?? null),
                    (int) ($row->applicationApproved ?? 0) === 1 ? 'approved' : ((int) ($row->declinedPosition ?? 0) === 1 ? 'declined' : 'pending'),
                ]),
            ],

            'membership_certificates' => [
                'select' => ['uuid', 'created_at'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->uuid ?? null,
                    self::shortDate($row->created_at ?? null),
                ]),
            ],

            'group_committee' => [
                'select' => ['active', 'created'],
                'format' => fn (stdClass $row): string => self::join([
                    (int) ($row->active ?? 0) === 1 ? 'active' : 'inactive',
                    self::shortDate($row->created ?? null),
                ]),
            ],
            'group_council' => [
                'select' => ['active', 'created'],
                'format' => fn (stdClass $row): string => self::join([
                    (int) ($row->active ?? 0) === 1 ? 'active' : 'inactive',
                    self::shortDate($row->created ?? null),
                ]),
            ],

            'system_users_emergency_contacts' => [
                'select' => ['name', 'cell'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->name ?? null,
                    $row->cell ?? null,
                ]),
            ],
            'system_users_form29' => [
                'select' => ['created', 'DSDResponse', 'DSDResponseDate'],
                'format' => fn (stdClass $row): string => self::join([
                    self::shortDate($row->created ?? null),
                    $row->DSDResponse ?? null,
                ]),
            ],

            'notifications' => [
                'select' => ['title', 'description', 'created', 'shown', 'dismissDate'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->title ?? null,
                    $row->description ?? null,
                    self::shortDate($row->created ?? null),
                    $row->dismissDate ? 'dismissed' : ((int) ($row->shown ?? 0) > 0 ? 'shown' : 'unseen'),
                ]),
            ],
            'notifications_archive' => [
                'select' => ['title', 'description', 'created'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->title ?? null,
                    $row->description ?? null,
                    self::shortDate($row->created ?? null),
                ]),
            ],
            'support_chats_start' => [
                'select' => ['topic', 'created', 'closed'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->topic ? self::truncate((string) $row->topic, 80) : null,
                    self::shortDate($row->created ?? null),
                    (int) ($row->closed ?? 0) === 1 ? 'closed' : 'open',
                ]),
            ],
            'support_chats' => [
                'select' => ['chat', 'direction', 'created'],
                'format' => fn (stdClass $row): string => self::join([
                    isset($row->direction) ? ((int) $row->direction === 1 ? '→' : '←') : null,
                    $row->chat ? self::truncate((string) $row->chat, 100) : null,
                    self::shortDate($row->created ?? null),
                ]),
            ],
            'system_users_email_verifications' => [
                'select' => ['emailAddress', 'dateVerified', 'active'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->emailAddress ?? null,
                    $row->dateVerified ? 'verified ' . self::shortDate($row->dateVerified) : 'unverified',
                ]),
            ],
            'telegram_messages' => [
                'select' => ['message', 'direction', 'date'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->direction ?? null,
                    $row->message ? self::truncate((string) $row->message, 100) : null,
                    self::shortDate($row->date ?? null),
                ]),
            ],
            'telegram_usernames' => [
                'select' => ['username', 'banned'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->username ?? null,
                    (int) ($row->banned ?? 0) === 1 ? 'banned' : null,
                ]),
            ],
            'ssalute_notifications' => [
                'select' => ['type', 'read_at', 'created_at'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->type ? class_basename((string) $row->type) : null,
                    self::shortDate($row->created_at ?? null),
                    $row->read_at ? 'read' : 'unread',
                ]),
            ],

            'admin_404_pages' => [
                'select' => ['actualURL', 'created'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->actualURL ? self::truncate((string) $row->actualURL, 80) : null,
                    self::shortDate($row->created ?? null),
                ]),
            ],
            'error_logging' => [
                'select' => ['page', 'created'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->page ?? null,
                    self::shortDate($row->created ?? null),
                ]),
            ],
            'system_user_logging' => [
                'select' => ['page', 'IP', 'created'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->page ? self::truncate((string) $row->page, 60) : null,
                    $row->IP ?? null,
                    self::shortDate($row->created ?? null),
                ]),
            ],
            'system_users_fingerprint' => [
                'select' => ['ipAddress', 'created'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->ipAddress ?? null,
                    self::shortDate($row->created ?? null),
                ]),
            ],
            'system_users_forced_logouts' => [
                'select' => ['IPAddress', 'date'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->IPAddress ?? null,
                    self::shortDate($row->date ?? null),
                ]),
            ],
            'group_user_picture_changes' => [
                'select' => ['created'],
                'format' => fn (stdClass $row): string => self::shortDate($row->created ?? null),
            ],
            'group_send_logon_details' => [
                'select' => ['created'],
                'format' => fn (stdClass $row): string => self::shortDate($row->created ?? null),
            ],
            'group_weekly_emails_emailed' => [
                'select' => ['mailType', 'sentDate'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->mailType ?? null,
                    self::shortDate($row->sentDate ?? null),
                ]),
            ],
            'event_competitions_location_logging' => [
                'select' => ['date', 'created'],
                'format' => fn (stdClass $row): string => self::shortDate($row->created ?? $row->date ?? null),
            ],
            'event_booking_setup_changes' => [
                'select' => ['name', 'created'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->name ?? null,
                    self::shortDate($row->created ?? null),
                ]),
            ],
            'ssalute_audits' => [
                'select' => ['event', 'auditable_type', 'created_at'],
                'format' => fn (stdClass $row): string => self::join([
                    $row->event ?? null,
                    $row->auditable_type ? class_basename((string) $row->auditable_type) : null,
                    self::shortDate($row->created_at ?? null),
                ]),
            ],
        ];
    }
}
