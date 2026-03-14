<?php

namespace Tests\Feature\Forms;

use App\Enums\Forms\Aam\AamStatuses;
use App\Livewire\Forms\Aam\AamRequestAction;
use App\Livewire\Forms\Aam\AamRequestForm;
use App\Livewire\Forms\Aam\AamRequestView;
use App\Models\Forms\ApplicationAdultMembershipRequest;
use App\Models\SystemUser;
use App\Settings\FormSettings;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class AamFormTest extends SdCoreTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('forms_aam_id_document');
        Storage::fake('forms_aam_criminal_record');
        Mail::fake();
    }

    // ──────────────────────────────────────────
    // Public Form (AamRequestForm)
    // ──────────────────────────────────────────

    #[Test]
    public function aam_form_returns_404_when_aam_is_disabled(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => false])->save();

        $this->get(route('forms.aam.form'))
            ->assertNotFound();
    }

    #[Test]
    public function aam_form_is_accessible_when_enabled(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => true])->save();

        $this->get(route('forms.aam.form'))
            ->assertOk()
            ->assertSeeLivewire(AamRequestForm::class);
    }

    #[Test]
    public function aam_form_creates_a_pending_request_on_submission(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => true])->save();

        $idDocument = UploadedFile::fake()->image('id.jpg');
        $criminalRecord = UploadedFile::fake()->image('clearance.jpg');

        Livewire::test(AamRequestForm::class)
            ->set('data.email', 'newapplicant@example.com')
            ->set('data.phone_number', '0821234567')
            ->set('data.has_south_african_id', true)
            ->set('data.id_number', '9406295154082')
            ->set('data.id_document', $idDocument)
            ->set('data.criminal_record', $criminalRecord)
            ->set('data.title', 'Mr')
            ->set('data.first_name', 'Robert')
            ->set('data.surname', 'Baden-Powell')
            ->set('data.sex', 'Male')
            ->set('data.date_of_birth', '1994-06-29')
            ->set('data.residential_address', '1 Scout Way, Cape Town')
            ->set('data.emergency_contact_name', 'Olave Baden-Powell')
            ->set('data.emergency_contact_phone_number', '0831234567')
            ->set('data.has_given_public_media_consent', false)
            ->set('data.scouting_consent', true)
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('forms_aam_requests', [
            'email' => 'newapplicant@example.com',
            'first_name' => 'Robert',
            'surname' => 'Baden-Powell',
            'status' => AamStatuses::PENDING->value,
        ]);
    }

    #[Test]
    public function aam_form_rejects_duplicate_email_from_existing_user(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => true])->save();

        SystemUser::factory()->create(['username' => 'existing@example.com']);

        Livewire::test(AamRequestForm::class)
            ->set('data.email', 'existing@example.com')
            ->call('create')
            ->assertHasErrors(['data.email']);
    }

    #[Test]
    public function aam_form_rejects_duplicate_email_from_pending_application(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => true])->save();

        ApplicationAdultMembershipRequest::factory()->create(['email' => 'pending@example.com']);

        Livewire::test(AamRequestForm::class)
            ->set('data.email', 'pending@example.com')
            ->call('create')
            ->assertHasErrors(['data.email']);
    }

    #[Test]
    public function aam_form_shows_success_state_after_submission(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => true])->save();

        $idDocument = UploadedFile::fake()->image('id.jpg');
        $criminalRecord = UploadedFile::fake()->image('clearance.jpg');

        Livewire::test(AamRequestForm::class)
            ->set('data.email', 'success@example.com')
            ->set('data.phone_number', '0821234567')
            ->set('data.has_south_african_id', true)
            ->set('data.id_number', '9406295154082')
            ->set('data.id_document', $idDocument)
            ->set('data.criminal_record', $criminalRecord)
            ->set('data.title', 'Mr')
            ->set('data.first_name', 'Test')
            ->set('data.surname', 'Applicant')
            ->set('data.sex', 'Male')
            ->set('data.date_of_birth', '1994-06-29')
            ->set('data.residential_address', '1 Scout Way')
            ->set('data.emergency_contact_name', 'Emergency Contact')
            ->set('data.emergency_contact_phone_number', '0831234567')
            ->set('data.has_given_public_media_consent', false)
            ->set('data.scouting_consent', true)
            ->call('create')
            ->assertSet('successfullyCompletedForm', true);
    }

    // ──────────────────────────────────────────
    // View Page (AamRequestView)
    // ──────────────────────────────────────────

    #[Test]
    public function aam_view_returns_404_when_aam_is_disabled(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => false])->save();

        $aamRequest = ApplicationAdultMembershipRequest::factory()->create();

        $this->get(route('forms.aam.view', $aamRequest->view_slug))
            ->assertNotFound();
    }

    #[Test]
    public function aam_view_is_accessible_with_valid_view_slug(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => true])->save();

        $aamRequest = ApplicationAdultMembershipRequest::factory()->create([
            'first_name' => 'Jane',
            'surname' => 'Doe',
        ]);

        $this->get(route('forms.aam.view', $aamRequest->view_slug))
            ->assertOk()
            ->assertSeeLivewire(AamRequestView::class);
    }

    #[Test]
    public function aam_view_returns_404_for_invalid_view_slug(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => true])->save();

        $this->get(route('forms.aam.view', 'invalid-slug-that-does-not-exist'))
            ->assertNotFound();
    }

    // ──────────────────────────────────────────
    // Action Page (AamRequestAction)
    // ──────────────────────────────────────────

    #[Test]
    public function aam_action_requires_authentication(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => true])->save();

        $aamRequest = ApplicationAdultMembershipRequest::factory()->create();

        $this->get(route('forms.aam.action', $aamRequest->action_slug))
            ->assertRedirect();
    }

    #[Test]
    public function aam_action_forbids_users_who_are_not_approvers(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => true])->save();

        $aamRequest = ApplicationAdultMembershipRequest::factory()->create();
        $nonApprover = SystemUser::factory()->withRole()->create();

        $this->actingAs($nonApprover)
            ->get(route('forms.aam.action', $aamRequest->action_slug))
            ->assertForbidden();
    }

    #[Test]
    public function super_admin_can_access_aam_action_page(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => true])->save();

        $aamRequest = ApplicationAdultMembershipRequest::factory()->create();
        $superAdmin = SystemUser::factory()->create(['username' => 'superadmin@example.com']);
        config(['ssalute.superuser_email' => 'superadmin@example.com']);

        $this->actingAs($superAdmin)
            ->get(route('forms.aam.action', $aamRequest->action_slug))
            ->assertOk();
    }

    #[Test]
    public function aam_action_returns_404_when_aam_is_disabled(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => false])->save();

        $aamRequest = ApplicationAdultMembershipRequest::factory()->create();
        $superAdmin = SystemUser::factory()->create(['username' => 'superadmin@example.com']);
        config(['ssalute.superuser_email' => 'superadmin@example.com']);

        $this->actingAs($superAdmin)
            ->get(route('forms.aam.action', $aamRequest->action_slug))
            ->assertNotFound();
    }

    // ──────────────────────────────────────────
    // Approve / Decline Actions
    // ──────────────────────────────────────────

    #[Test]
    public function super_admin_can_approve_a_pending_aam_request(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => true])->save();

        $aamRequest = ApplicationAdultMembershipRequest::factory()->create(['status' => AamStatuses::PENDING]);
        $superAdmin = SystemUser::factory()->create(['username' => 'superadmin@example.com']);
        config(['ssalute.superuser_email' => 'superadmin@example.com']);

        Livewire::actingAs($superAdmin)
            ->test(AamRequestAction::class, ['aamRequest' => $aamRequest])
            ->call('approveAction', [
                'actioned_reason_external' => 'Welcome to Scouts!',
                'actioned_notes_internal' => 'All checks passed.',
            ]);

        $this->assertDatabaseHas('forms_aam_requests', [
            'id' => $aamRequest->id,
            'status' => AamStatuses::APPROVED->value,
            'actioned_by' => $superAdmin->id,
            'actioned_reason_external' => 'Welcome to Scouts!',
        ]);
    }

    #[Test]
    public function super_admin_can_decline_a_pending_aam_request(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => true])->save();

        $aamRequest = ApplicationAdultMembershipRequest::factory()->create(['status' => AamStatuses::PENDING]);
        $superAdmin = SystemUser::factory()->create(['username' => 'superadmin@example.com']);
        config(['ssalute.superuser_email' => 'superadmin@example.com']);

        Livewire::actingAs($superAdmin)
            ->test(AamRequestAction::class, ['aamRequest' => $aamRequest])
            ->call('declineAction', [
                'actioned_notes_internal' => 'Background check failed.',
                'actioned_reason_external' => 'Unable to approve at this time.',
            ]);

        $this->assertDatabaseHas('forms_aam_requests', [
            'id' => $aamRequest->id,
            'status' => AamStatuses::DECLINED->value,
            'actioned_by' => $superAdmin->id,
            'actioned_reason_external' => 'Unable to approve at this time.',
        ]);
    }

    #[Test]
    public function already_approved_request_cannot_be_approved_again(): void
    {
        app(FormSettings::class)->fill(['aam_enabled' => true])->save();

        $superAdmin = SystemUser::factory()->create(['username' => 'superadmin@example.com']);
        config(['ssalute.superuser_email' => 'superadmin@example.com']);

        $aamRequest = ApplicationAdultMembershipRequest::factory()->approved()->create([
            'actioned_by' => $superAdmin->id,
        ]);

        $originalActionedAt = $aamRequest->actioned_at;

        // Calling approve on an already-approved request is a no-op
        $aamRequest->approve($superAdmin, 'Trying again.');

        $this->assertEquals(AamStatuses::APPROVED, $aamRequest->fresh()->status);
        $this->assertEquals(
            $originalActionedAt->toDateTimeString(),
            $aamRequest->fresh()->actioned_at->toDateTimeString()
        );
    }

    // ──────────────────────────────────────────
    // Model: approve() / decline()
    // ──────────────────────────────────────────

    #[Test]
    public function approve_method_sets_correct_fields(): void
    {
        $actioner = SystemUser::factory()->create();
        $aamRequest = ApplicationAdultMembershipRequest::factory()->create(['status' => AamStatuses::PENDING]);

        $aamRequest->approve(
            actionedBy: $actioner,
            externalReason: 'Welcome aboard!',
            internalNotes: 'Verified ID and clearance.'
        );

        $aamRequest->refresh();

        $this->assertEquals(AamStatuses::APPROVED, $aamRequest->status);
        $this->assertEquals($actioner->id, $aamRequest->actioned_by);
        $this->assertEquals('Welcome aboard!', $aamRequest->actioned_reason_external);
        $this->assertEquals('Verified ID and clearance.', $aamRequest->actioned_notes_internal);
        $this->assertNotNull($aamRequest->actioned_at);
    }

    #[Test]
    public function decline_method_sets_correct_fields(): void
    {
        $actioner = SystemUser::factory()->create();
        $aamRequest = ApplicationAdultMembershipRequest::factory()->create(['status' => AamStatuses::PENDING]);

        $aamRequest->decline(
            actionedBy: $actioner,
            externalReason: 'Background check failed.',
            internalNotes: 'Police clearance issue.'
        );

        $aamRequest->refresh();

        $this->assertEquals(AamStatuses::DECLINED, $aamRequest->status);
        $this->assertEquals($actioner->id, $aamRequest->actioned_by);
        $this->assertEquals('Background check failed.', $aamRequest->actioned_reason_external);
        $this->assertEquals('Police clearance issue.', $aamRequest->actioned_notes_internal);
        $this->assertNotNull($aamRequest->actioned_at);
    }

    #[Test]
    public function decline_does_nothing_on_already_actioned_request(): void
    {
        $actioner = SystemUser::factory()->create();
        $aamRequest = ApplicationAdultMembershipRequest::factory()->approved()->create([
            'actioned_by' => $actioner->id,
        ]);

        $aamRequest->decline(
            actionedBy: $actioner,
            externalReason: 'Late attempt.',
        );

        $aamRequest->refresh();

        $this->assertEquals(AamStatuses::APPROVED, $aamRequest->status);
    }
}
