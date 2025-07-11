<?php

namespace App\Console\Commands;

use App\Providers\AppServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SanitizeDatabase extends Command
{
    protected $signature = 'app:sanitize-database';

    protected $description = 'This is to take the current Scouts Digital Database and sanitize it for use in demo/test environments. Long Term this should be replaced with good factories and seeders';

    public function handle(): int
    {
        $startTime = microtime(true);
        $this->info('Processing...');

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('admin_404_pages')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('admin_bad_logons')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('admin_banned_ips')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('admin_good_logons')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('advancement_cubs')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('advancement_documents')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('advancement_meerkats')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('advancement_photos')->update(['PDFLocation' => '-', 'thumbLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('advancement_rovers')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('advancement_scouts')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_award_applications')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_award_info')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_charge_info')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_criminal_check')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_disciplinary_info')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_documents')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_documents_groups')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_past_service_info')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_police_clearance')->update(['documentLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_resign_leader')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_retire_leader')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_terminate_leader')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_training_courses')->update(['agendaPDFLocation' => '-', 'materialPDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_training_courses_annual_bookings')->update(['invoiceLocation' => '-', 'POPLocation' => '-', 'userPIN' => null]);

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_training_locations')->update(['contact' => 'san-name','tel' => null,'cell' => null,'email' => null,]);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_training_past')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_warrant_applications')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_warrant_extensions')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('ams_warrant_info')->update(['PDFLocation' => '-']);

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('api_keys')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('api_usage')->truncate();

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('badges_cubs')->update(['PDFLocation' => '-', 'instructorsName' => null]);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('badges_documents')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('badges_meerkats')->update(['PDFLocation' => '-', 'instructorsName' => null]);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('badges_photos')->update(['PDFLocation' => '-', 'thumbLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('badges_rovers')->update(['PDFLocation' => '-', 'instructorsName' => null]);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('badges_scouts')->update(['PDFLocation' => '-', 'instructorsName' => null]);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('census_documents')->update(['XLSLocation' => '-']);

        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_cart');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_delivery_address');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_delivery_providers');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_delivery_providers_delivery_options');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_group_fees');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_order_status');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_orders');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_orders_details');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_payfast_transactions');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_products');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_products_cat');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_products_images');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_products_reviews');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_products_stock');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_products_sub_subcat');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_products_subcat');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_search_queries');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_shoppers_logins');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_stock_locations');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_stock_suppliers');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_wallet');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_wallets_transaction_types');
        Schema::connection(AppServiceProvider::DB_SD_CORE)->dropIfExists('commerce_wish_list');

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('directory_professional')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('directory_professional_likes')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('directory_professional_reviews')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('error_logging')->truncate();

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_booking_setup_changes')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competition_score_adjudication')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_answers')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_finances_invoices')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_finances_payments')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_gps')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_groups_attending')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_groups_participating')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_internal_competitions')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_judges')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_judges_types')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_location_logging')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_questions')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_scoring')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_scoring_areas')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_scoring_dnp')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_scoring_sheets')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_scoring_sheets_headings')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_competitions_survey_responses')->truncate();

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_user_booking_credit_notes')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_user_booking_invoices')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_user_booking_payments')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_user_booking_pops')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_user_booking_notes')->update(['note' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('event_user_booking_transport')->update(['name' => '-']);

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_accounts_transfers')->update(['notes' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_account_transfers_notes')->update(['note' => '-']);

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_edit_record')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_documents')->update(['location' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_event_documents')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_events')->update(['locationName' => '-', 'locationAddress' => '-', 'locationLat' => null, 'locationLon' => null, 'permitDocLocation' => null, 'eventPSPin' => 1, 'eventTSPin' => 1, 'eventSGLPin' => 1, 'eventDCPin' => 1, 'eventOtherDCPin' => 1, 'surveyURL' => null, 'leaderboardURL' => null, 'calendarURL' => null]);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_financial_credit_notes')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_financial_invoices')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_financial_invoices_items')->update(['name' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_newsletters')->update(['uploadedFile' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_parents_committee_minutes')->update(['uploadedFile' => '-']);

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_programs')->update(['document' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_programs_documents')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_programs_online_tasks')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_programs_online_tasks_documents')->update(['location' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_programs_online_tasks_images')->update(['location' => '-']);

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('groups')->update(['email' => null]);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_scouts_charges')->update(['PDFLocation' => '-']);

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('groups_property')->update(['landlordName' => null, 'landlordContactPerson' => null, 'landlordContactPersonCell' => null, 'landlordContactPersonEmail' => null, 'insuranceContactPerson' => null, 'insuranceContactPersonEmail' => null, 'insuranceContactPersonCell' => null]);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_star_awards')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_user_picture_changes')->update(['pictureLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('group_youth_charges')->update(['PDFLocation' => '-']);

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('info_sharing')->update(['contactPerson' => '-', 'email' => null, 'tel' => null]);



        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_activity_center_bases')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_activity_centers')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_adult_allocations')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_adult_roles')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_application')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_beds')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_beds_allocations')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_bus_info')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_buses_users')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_core_team')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('notifications')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_eoi')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_expr_of_interest')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_generated_pdfs')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_info')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_initial_thoughts')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_invoices')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_invoices_items')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_patrols')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_payment_types')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_payments')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_position_offered')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_scouters')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_sub_camp_troop_allocations')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_sub_camps')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_troop_patrol_allocations')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('jamboree_troops')->truncate();


        DB::connection(AppServiceProvider::DB_SD_CORE)->table('projects')->update(['document' => '-', 'contactPerson' => '-', 'contactEmail' => null, 'contactCell' => null]);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('scouter_reviews')->update(['review' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('services_purchased')->truncate();

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('support_chats')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('support_chats_start')->truncate();

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('system_user_logging')->truncate();

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('system_users')->update(
            [
                'username' => DB::raw('CONCAT(`id`, "--")'),
                'passwordNew' => null,
                'passwordEnc' => null,
                'lastPasswordChange' => null,
                'passwordChangedBy' => null,
                'first_name' => null,
                'otherName' => null,
                'surname' => null,
                'previousSurname' => null,
                'knownName' => null,
                'scoutName' => null,
                'photo' => null,
                'thumb' => null,
                'idNumber' => null,
                'IDBookLocation' => null,
                'passportNumber' => null,
                'partnersFullName' => null,
                'sex' => null,
                'race' => null,
                'dob' => null,
                'phys_address' => null,
                'gpsLat' => null,
                'gpsLon' => null,
                'gpsAccuracy' => null,
                'postal_address' => null,
                'cellNr' => null,
                'officeNr' => null,
                'homeNr' => null,
                'faxNr' => null,
                'medicalAidName' => null,
                'medicalAidNr' => null,
                'medicalAidPrincipalMember' => null,
                'doctorsName' => null,
                'doctorsPhone' => null,
                'allergies' => null,
                'allergiesInstructions' => null,
                'disabilities' => null,
                'disabilitiesInstructions' => null,
                'medicalConditions' => null,
                'medicalConditionsInstructions' => null,
                'currentMedication' => null,
                'emergencyContactName' => null,
                'emergencyContactCell' => null,
                'emergencyContactTel' => null,
                'emergencyContactRelationship' => null,
                'specialMealRequirements' => null,
                'religiousAffiliation' => null,
                'religion' => null,
                'religiousBelief' => null,
                'school' => null,
                'hobbies' => null,
                'sports' => null,
                'interests' => null,
                '100CharId' => null,
                'uniquePIN' => null,
                'occupation' => null,
                'typeOfEmployment' => null,
                'employer' => null,
                'maritalStatus' => null,
                'ref1Name' => null,
                'ref1Address' => null,
                'ref1Tel' => null,
                'ref2Name' => null,
                'ref2Address' => null,
                'ref2Tel' => null,
                'SSANumber' => null,
                'generalNotes' => null,
            ]
        );
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('system_users_email_verifications')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('system_users_emergency_contacts')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('system_users_forced_logouts')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('system_users_form29')->update(['PDFLocation' => '-']);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('system_users_other_roles')->update(['creationNotes' => null]);
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('system_users_passwords_emailed')->truncate();

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('telegram_ban_count')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('telegram_currently_chatting')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('telegram_messages')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('telegram_random_message')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('telegram_sent_human_message')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('telegram_standard_messages')->truncate();
        DB::connection(AppServiceProvider::DB_SD_CORE)->table('telegram_usernames')->truncate();

        DB::connection(AppServiceProvider::DB_SD_CORE)->table('wsm16_expression')->truncate();

        $endTime = microtime(true);
        $this->info('Sanitization completed in ' . round($endTime - $startTime, 2) . ' seconds.');

        return Command::SUCCESS;
    }
}
