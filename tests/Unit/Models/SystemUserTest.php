<?php

namespace Tests\Unit\Models;

use App\Models\SystemUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SystemUserTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    #[Test]
    public function has_any_active_role_returns_true_when_active_role_exists(): void
    {
        $query = Mockery::mock(HasMany::class);
        $query->shouldReceive('where')->with('active', 1)->andReturnSelf();
        $query->shouldReceive('exists')->andReturn(true);

        $user = Mockery::mock(SystemUser::class)->makePartial();
        $user->shouldReceive('roleAttachments')->andReturn($query);

        $this->assertTrue($user->hasAnyActiveRole());
    }

    #[Test]
    public function has_any_active_role_returns_false_when_no_active_roles(): void
    {
        $query = Mockery::mock(HasMany::class);
        $query->shouldReceive('where')->with('active', 1)->andReturnSelf();
        $query->shouldReceive('exists')->andReturn(false);

        $user = Mockery::mock(SystemUser::class)->makePartial();
        $user->shouldReceive('roleAttachments')->andReturn($query);

        $this->assertFalse($user->hasAnyActiveRole());
    }

    #[Test]
    public function can_access_general_panel_when_user_has_any_active_role(): void
    {
        $user = Mockery::mock(SystemUser::class)->makePartial();
        $user->shouldReceive('hasAnyActiveRole')->andReturn(true);

        $panel = Mockery::mock(Panel::class);
        $panel->shouldReceive('getId')->andReturn('general');

        $this->assertTrue($user->canAccessPanel($panel));
    }

    #[Test]
    public function cannot_access_general_panel_when_user_has_no_active_roles(): void
    {
        $user = Mockery::mock(SystemUser::class)->makePartial();
        $user->shouldReceive('hasAnyActiveRole')->andReturn(false);

        $panel = Mockery::mock(Panel::class);
        $panel->shouldReceive('getId')->andReturn('general');

        $this->assertFalse($user->canAccessPanel($panel));
    }

    #[Test]
    public function can_access_admin_panel_as_super_admin(): void
    {
        $user = Mockery::mock(SystemUser::class)->makePartial();
        $user->shouldReceive('isSuperAdmin')->andReturn(true);

        $panel = Mockery::mock(Panel::class);
        $panel->shouldReceive('getId')->andReturn('admin');

        $this->assertTrue($user->canAccessPanel($panel));
    }

    #[Test]
    public function cannot_access_admin_panel_without_being_super_admin(): void
    {
        $user = Mockery::mock(SystemUser::class)->makePartial();
        $user->shouldReceive('isSuperAdmin')->andReturn(false);

        $panel = Mockery::mock(Panel::class);
        $panel->shouldReceive('getId')->andReturn('admin');

        $this->assertFalse($user->canAccessPanel($panel));
    }

    #[Test]
    public function cannot_access_unknown_panel(): void
    {
        $user = Mockery::mock(SystemUser::class)->makePartial();

        $panel = Mockery::mock(Panel::class);
        $panel->shouldReceive('getId')->andReturn('unknown');

        $this->assertFalse($user->canAccessPanel($panel));
    }
}
