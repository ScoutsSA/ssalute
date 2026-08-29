<?php

namespace Tests\Feature\Auth;

use App\Auth\SignedSsoToken;
use App\Models\SystemUser;
use Illuminate\Support\Facades\Log;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\SdCoreTestCase;

class ScoutsDigitalSsoTest extends SdCoreTestCase
{
    protected const SECRET = 'dGVzdC1zZWNyZXQtdGVzdC1zZWNyZXQtdGVzdC1zZWNyZXQ=';

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('ssalute.scouts_digital_sso_secret', self::SECRET);
    }

    #[Test]
    public function a_valid_token_logs_the_member_in_and_lands_on_their_dashboard(): void
    {
        Log::spy();
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->get($this->url($this->token(['uid' => $user->id])))
            ->assertRedirect("/member/{$tenant->id}/dashboard");

        $this->assertAuthenticatedAs($user);
        Log::shouldHaveReceived('info')->with('sso.scouts_digital.logged_in', ['user_id' => $user->id])->once();
    }

    #[Test]
    public function a_member_without_a_tenant_lands_in_the_holding_zone(): void
    {
        $user = SystemUser::factory()->create();

        $this->get($this->url($this->token(['uid' => $user->id])))
            ->assertRedirect('/holding-zone');

        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function an_expired_token_is_refused_with_a_plain_page_and_a_log_line(): void
    {
        Log::spy();
        $user = SystemUser::factory()->create();
        $token = $this->token(['uid' => $user->id, 'iat' => now()->getTimestamp() - 30, 'exp' => now()->getTimestamp() - 1]);

        $this->get($this->url($token))
            ->assertForbidden()
            ->assertSee('That link has expired')
            ->assertSee('/holding-zone/login');

        $this->assertGuest();
        Log::shouldHaveReceived('warning')->with('sso.scouts_digital.rejected', ['reason' => 'expired'])->once();
        Log::shouldNotHaveReceived('warning', [Mockery::any(), Mockery::on(fn (array $context): bool => str_contains(json_encode($context), $token))]);
    }

    #[Test]
    public function a_tampered_token_is_refused(): void
    {
        Log::spy();
        $user = SystemUser::factory()->create();
        $other = SystemUser::factory()->create();

        $forged = (new SignedSsoToken('scouts-digital', 'another-secret'))->issue(['uid' => $other->id]);
        [$payload] = explode('.', $this->token(['uid' => $user->id]));

        $this->get($this->url($forged))->assertForbidden();
        $this->get($this->url("{$payload}.0000"))->assertForbidden();
        $this->get($this->url('nonsense'))->assertForbidden();

        $this->assertGuest();
        Log::shouldHaveReceived('warning')->with('sso.scouts_digital.rejected', ['reason' => 'bad_signature'])->twice();
        Log::shouldHaveReceived('warning')->with('sso.scouts_digital.rejected', ['reason' => 'malformed'])->once();
    }

    #[Test]
    public function a_token_only_works_once(): void
    {
        Log::spy();
        $user = SystemUser::factory()->create();
        $token = $this->token(['uid' => $user->id]);

        $this->get($this->url($token))->assertRedirect('/holding-zone');

        auth()->logout();

        $this->get($this->url($token))->assertForbidden();

        $this->assertGuest();
        Log::shouldHaveReceived('warning')->with('sso.scouts_digital.rejected', ['reason' => 'replayed'])->once();
    }

    #[Test]
    public function inactive_and_unknown_members_are_refused(): void
    {
        Log::spy();
        $inactive = SystemUser::factory()->inactive()->create();

        $this->get($this->url($this->token(['uid' => $inactive->id])))->assertForbidden();
        $this->get($this->url($this->token(['uid' => 999999999])))->assertForbidden();

        $this->assertGuest();
        Log::shouldHaveReceived('warning')->with('sso.scouts_digital.rejected', ['reason' => 'inactive_member', 'user_id' => $inactive->id])->once();
        Log::shouldHaveReceived('warning')->with('sso.scouts_digital.rejected', ['reason' => 'unknown_member', 'user_id' => 999999999])->once();
    }

    #[Test]
    public function the_route_is_dark_without_a_secret(): void
    {
        $user = SystemUser::factory()->create();
        $token = $this->token(['uid' => $user->id]);

        config()->set('ssalute.scouts_digital_sso_secret', '');

        $this->get($this->url($token))->assertNotFound();
        $this->assertGuest();
    }

    #[Test]
    public function intended_accepts_a_relative_path_and_ignores_anything_else(): void
    {
        $user = SystemUser::factory()->create();

        $this->get($this->url($this->token(['uid' => $user->id]), '/settings/profile'))
            ->assertRedirect('/settings/profile');

        $this->get($this->url($this->token(['uid' => $user->id]), 'https://evil.example.test/phish'))
            ->assertRedirect('/holding-zone');

        $this->get($this->url($this->token(['uid' => $user->id]), '//evil.example.test/phish'))
            ->assertRedirect('/holding-zone');
    }

    #[Test]
    public function a_guest_bounced_to_the_login_page_lands_where_they_were_going(): void
    {
        $user = SystemUser::factory()->withRole()->create();
        $tenant = $user->roleAttachments()->first();

        $this->get("/member/{$tenant->id}/dashboard")->assertRedirect('/login');

        $this->get($this->url($this->token(['uid' => $user->id])))
            ->assertRedirect(url("/member/{$tenant->id}/dashboard"));

        $this->assertNull(session('url.intended'));
    }

    #[Test]
    public function the_route_is_rate_limited_per_ip(): void
    {
        foreach (range(1, 10) as $attempt) {
            $this->get($this->url('nonsense'))->assertForbidden();
        }

        $this->get($this->url('nonsense'))->assertStatus(429);
    }

    /**
     * @param  array{uid: int, iat?: int, exp?: int, nonce?: string}  $claims
     */
    protected function token(array $claims): string
    {
        return SignedSsoToken::forScoutsDigital()->issue($claims);
    }

    protected function url(string $token, ?string $intended = null): string
    {
        return route('sso.scouts-digital', array_filter(['token' => $token, 'intended' => $intended]));
    }
}
