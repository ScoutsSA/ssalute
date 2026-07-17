<?php

namespace Tests\Feature;

use App\Sync\Anonymizers\AnonymizeLoginHistory;
use App\Sync\Anonymizers\AnonymizeOrganisationContacts;
use App\Sync\Anonymizers\AnonymizeSystemUserEmailVerifications;
use App\Sync\Anonymizers\AnonymizeSystemUsers;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SyncAnonymizersTest extends TestCase
{
    protected string $connection = 'sync_test';

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.connections.' . $this->connection, [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => false,
        ]);

        DB::purge($this->connection);
    }

    #[Test]
    public function it_scrubs_the_member_identity_table_with_unique_per_member_values(): void
    {
        $this->schema()->create('system_users', function (Blueprint $table): void {
            $table->integer('id');
            $table->string('username')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('first_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('idNumber')->nullable();
            $table->string('passportNumber')->nullable();
            $table->text('phys_address')->nullable();
            $table->string('cellNr')->nullable();
            $table->string('medicalAidNr')->nullable();
            $table->string('emergencyContactName')->nullable();
            $table->string('religion')->nullable();
            $table->text('ref1Address')->nullable();
            $table->string('sex')->nullable();
            $table->integer('active')->nullable();
        });

        $this->table('system_users')->insert([
            ['id' => 1, 'username' => 'jane@real.co.za', 'remember_token' => 'tok1', 'first_name' => 'Jane', 'surname' => 'Smith', 'idNumber' => '8001015800081', 'passportNumber' => 'A1234567', 'phys_address' => '12 Real Road', 'cellNr' => '0821234567', 'medicalAidNr' => '99887766', 'emergencyContactName' => 'John Smith', 'religion' => 'Methodist', 'ref1Address' => '5 Referee Ave', 'sex' => 'F', 'active' => 1],
            ['id' => 2, 'username' => 'peter@real.co.za', 'remember_token' => 'tok2', 'first_name' => 'Peter', 'surname' => 'Jones', 'idNumber' => '9002026900082', 'passportNumber' => 'B7654321', 'phys_address' => '34 Real Street', 'cellNr' => '0839876543', 'medicalAidNr' => '11223344', 'emergencyContactName' => 'Mary Jones', 'religion' => 'Catholic', 'ref1Address' => '9 Referee Rd', 'sex' => 'M', 'active' => 1],
        ]);

        app(AnonymizeSystemUsers::class)($this->connection);

        $one = $this->table('system_users')->where('id', 1)->first();
        $two = $this->table('system_users')->where('id', 2)->first();

        $this->assertSame('member1@example.test', $one->username);
        $this->assertSame('member2@example.test', $two->username);
        $this->assertNull($one->remember_token);
        $this->assertSame('Member', $one->first_name);
        $this->assertSame('No1', $one->surname);
        $this->assertSame('No2', $two->surname);
        $this->assertSame('0000000000001', $one->idNumber);
        $this->assertSame('', $one->passportNumber);
        $this->assertSame('Redacted', $one->phys_address);
        $this->assertSame('08000000001', $one->cellNr);
        $this->assertSame('', $one->medicalAidNr);
        $this->assertSame('', $one->emergencyContactName);
        $this->assertSame('', $one->religion);
        $this->assertSame('', $one->ref1Address);

        $this->assertSame('F', $one->sex, 'Non-sensitive demographic columns are preserved.');
        $this->assertSame(1, (int) $one->active);
    }

    #[Test]
    public function it_skips_columns_and_tables_that_are_absent_from_the_snapshot(): void
    {
        $this->schema()->create('system_users', function (Blueprint $table): void {
            $table->integer('id');
            $table->string('username')->nullable();
        });

        $this->table('system_users')->insert(['id' => 7, 'username' => 'someone@real.co.za']);

        app(AnonymizeSystemUsers::class)($this->connection);

        $this->assertSame('member7@example.test', $this->table('system_users')->where('id', 7)->value('username'));

        app(AnonymizeSystemUserEmailVerifications::class)($this->connection);
        app(AnonymizeLoginHistory::class)($this->connection);
        app(AnonymizeOrganisationContacts::class)($this->connection);
    }

    #[Test]
    public function it_scrubs_stored_member_emails_and_verification_messages(): void
    {
        $this->schema()->create('system_users_email_verifications', function (Blueprint $table): void {
            $table->integer('id');
            $table->integer('userID');
            $table->string('emailAddress')->nullable();
            $table->text('response')->nullable();
            $table->text('messageReceivedBack')->nullable();
        });

        $this->table('system_users_email_verifications')->insert([
            ['id' => 1, 'userID' => 41, 'emailAddress' => 'jane@real.co.za', 'response' => 'delivered to jane', 'messageReceivedBack' => 'thanks'],
            ['id' => 2, 'userID' => 42, 'emailAddress' => 'peter@real.co.za', 'response' => 'delivered to peter', 'messageReceivedBack' => 'ok'],
        ]);

        app(AnonymizeSystemUserEmailVerifications::class)($this->connection);

        $this->assertSame('member41@example.test', $this->table('system_users_email_verifications')->where('id', 1)->value('emailAddress'));
        $this->assertSame('member42@example.test', $this->table('system_users_email_verifications')->where('id', 2)->value('emailAddress'));
        $this->assertSame('', $this->table('system_users_email_verifications')->where('id', 1)->value('response'));
        $this->assertSame('', $this->table('system_users_email_verifications')->where('id', 1)->value('messageReceivedBack'));
    }

    #[Test]
    public function it_wipes_credential_audit_trails_but_keeps_non_credential_columns(): void
    {
        $this->schema()->create('admin_good_logons', function (Blueprint $table): void {
            $table->integer('id');
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('ip')->nullable();
        });

        $this->table('admin_good_logons')->insert([
            ['id' => 1, 'username' => 'jane@real.co.za', 'password' => 'hunter2', 'ip' => '10.0.0.1'],
            ['id' => 2, 'username' => 'peter@real.co.za', 'password' => 'letmein', 'ip' => '10.0.0.2'],
        ]);

        app(AnonymizeLoginHistory::class)($this->connection);

        $rows = $this->table('admin_good_logons')->orderBy('id')->get();
        foreach ($rows as $row) {
            $this->assertSame('redacted', $row->username);
            $this->assertSame('', $row->password);
        }
        $this->assertSame('10.0.0.1', $rows->firstWhere('id', 1)->ip, 'Non-credential audit columns are preserved.');
    }

    #[Test]
    public function it_scrubs_organisation_contacts_and_application_forms_but_keeps_org_names(): void
    {
        $this->schema()->create('groups', function (Blueprint $table): void {
            $table->integer('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('bankAccountNumber')->nullable();
        });

        $this->schema()->create('forms_aam_requests', function (Blueprint $table): void {
            $table->integer('id');
            $table->string('first_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('id_number')->nullable();
            $table->string('email')->nullable();
            $table->text('residential_address')->nullable();
            $table->string('emergency_contact_phone_number')->nullable();
        });

        $this->table('groups')->insert(['id' => 1, 'name' => '1st Rondebosch', 'email' => 'treasurer@real.co.za', 'bankAccountNumber' => '1234567890']);
        $this->table('forms_aam_requests')->insert(['id' => 1, 'first_name' => 'Sam', 'surname' => 'Taylor', 'id_number' => '8501015800088', 'email' => 'sam@real.co.za', 'residential_address' => '7 Home Lane', 'emergency_contact_phone_number' => '0821112222']);

        app(AnonymizeOrganisationContacts::class)($this->connection);

        $group = $this->table('groups')->where('id', 1)->first();
        $this->assertSame('1st Rondebosch', $group->name, 'Organisation names are preserved.');
        $this->assertSame('redacted@example.test', $group->email);
        $this->assertSame('', $group->bankAccountNumber);

        $form = $this->table('forms_aam_requests')->where('id', 1)->first();
        $this->assertSame('Applicant', $form->first_name);
        $this->assertSame('Redacted', $form->surname);
        $this->assertSame('', $form->id_number);
        $this->assertSame('redacted@example.test', $form->email);
        $this->assertSame('Redacted', $form->residential_address);
        $this->assertSame('0800000000', $form->emergency_contact_phone_number);
    }

    #[Test]
    public function it_warns_when_an_expected_column_is_absent_from_the_snapshot(): void
    {
        $this->schema()->create('system_users', function (Blueprint $table): void {
            $table->integer('id');
            $table->string('username')->nullable();
        });

        $this->table('system_users')->insert(['id' => 1, 'username' => 'jane@real.co.za']);

        Log::shouldReceive('warning')
            ->once()
            ->withArgs(fn (string $message, array $context): bool => $message === 'sync.anonymizer.columns_missing'
                && $context['table'] === 'system_users'
                && in_array('idNumber', $context['columns'], true));

        app(AnonymizeSystemUsers::class)($this->connection);
    }

    #[Test]
    public function it_warns_when_an_expected_table_is_absent_from_the_snapshot(): void
    {
        Log::shouldReceive('warning')
            ->with('sync.anonymizer.table_missing', Mockery::on(
                fn (array $context): bool => $context['table'] === 'admin_good_logons'
            ))
            ->once();
        Log::shouldReceive('warning')->andReturnNull();

        app(AnonymizeLoginHistory::class)($this->connection);
    }

    protected function schema(): \Illuminate\Database\Schema\Builder
    {
        return Schema::connection($this->connection);
    }

    protected function table(string $table): \Illuminate\Database\Query\Builder
    {
        return DB::connection($this->connection)->table($table);
    }
}
