<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\RedirectToValidTenant;
use Filament\Facades\Filament;
use Filament\Models\Contracts\HasDefaultTenant;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RedirectToValidTenantTest extends TestCase
{
    private RedirectToValidTenant $middleware;

    private $next;

    private bool $nextCalled = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->middleware = new RedirectToValidTenant;
        $this->nextCalled = false;
        $this->next = function ($req) {
            $this->nextCalled = true;

            return response('ok');
        };
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    #[Test]
    public function passes_through_when_panel_has_no_tenancy(): void
    {
        $panel = $this->makePanel();
        $panel->shouldReceive('hasTenancy')->andReturn(false);
        Filament::shouldReceive('getCurrentOrDefaultPanel')->andReturn($panel);

        $this->middleware->handle(Mockery::mock(Request::class), $this->next);

        $this->assertTrue($this->nextCalled);
    }

    #[Test]
    public function passes_through_when_route_has_no_tenant_parameter(): void
    {
        $panel = $this->makePanel();
        $panel->shouldReceive('hasTenancy')->andReturn(true);
        Filament::shouldReceive('getCurrentOrDefaultPanel')->andReturn($panel);

        $route = Mockery::mock(Route::class);
        $route->shouldReceive('hasParameter')->with('tenant')->andReturn(false);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('route')->withNoArgs()->andReturn($route);

        $this->middleware->handle($request, $this->next);

        $this->assertTrue($this->nextCalled);
    }

    #[Test]
    public function passes_through_when_user_is_not_authenticated(): void
    {
        $panel = $this->makePanel();
        $panel->shouldReceive('hasTenancy')->andReturn(true);
        $panel->shouldReceive('auth')->andReturn($this->makeGuard(null));
        Filament::shouldReceive('getCurrentOrDefaultPanel')->andReturn($panel);

        $route = Mockery::mock(Route::class);
        $route->shouldReceive('hasParameter')->with('tenant')->andReturn(true);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('route')->withNoArgs()->andReturn($route);

        $this->middleware->handle($request, $this->next);

        $this->assertTrue($this->nextCalled);
    }

    #[Test]
    public function passes_through_when_tenant_does_not_exist(): void
    {
        $user = Mockery::mock(HasTenants::class . ',' . HasDefaultTenant::class);

        $panel = $this->makePanel();
        $panel->shouldReceive('hasTenancy')->andReturn(true);
        $panel->shouldReceive('auth')->andReturn($this->makeGuard($user));
        $panel->shouldReceive('getTenant')->with('999')->andThrow(ModelNotFoundException::class);
        Filament::shouldReceive('getCurrentOrDefaultPanel')->andReturn($panel);

        $this->expectException(ModelNotFoundException::class);

        $this->middleware->handle($this->makeRequest(tenantKey: '999'), $this->next);
    }

    #[Test]
    public function passes_through_when_user_already_owns_the_tenant(): void
    {
        $tenant = $this->makeTenant('123');

        $user = Mockery::mock(HasTenants::class . ',' . HasDefaultTenant::class);
        $user->shouldReceive('canAccessTenant')->with($tenant)->andReturn(true);

        $panel = $this->makePanel();
        $panel->shouldReceive('hasTenancy')->andReturn(true);
        $panel->shouldReceive('auth')->andReturn($this->makeGuard($user));
        $panel->shouldReceive('getTenant')->with('123')->andReturn($tenant);
        Filament::shouldReceive('getCurrentOrDefaultPanel')->andReturn($panel);

        $this->middleware->handle($this->makeRequest(tenantKey: '123'), $this->next);

        $this->assertTrue($this->nextCalled);
    }

    #[Test]
    public function redirects_to_users_own_tenant_when_shared_link_uses_someone_elses_tenant(): void
    {
        $sharedTenant = $this->makeTenant('123');
        $usersTenant = $this->makeTenant('456');

        $user = Mockery::mock(HasTenants::class . ',' . HasDefaultTenant::class);
        $user->shouldReceive('canAccessTenant')->with($sharedTenant)->andReturn(false);
        $user->shouldReceive('getDefaultTenant')->andReturn($usersTenant);

        $panel = $this->makePanel();
        $panel->shouldReceive('hasTenancy')->andReturn(true);
        $panel->shouldReceive('auth')->andReturn($this->makeGuard($user));
        $panel->shouldReceive('getTenant')->with('123')->andReturn($sharedTenant);
        Filament::shouldReceive('getCurrentOrDefaultPanel')->andReturn($panel);

        $response = $this->middleware->handle($this->makeRequest(tenantKey: '123'), $this->next);

        $this->assertFalse($this->nextCalled);
        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertStringContainsString('456', $response->getTargetUrl());
    }

    #[Test]
    public function passes_through_when_user_cannot_access_shared_tenant_and_has_no_roles(): void
    {
        $sharedTenant = $this->makeTenant('123');

        $user = Mockery::mock(HasTenants::class . ',' . HasDefaultTenant::class);
        $user->shouldReceive('canAccessTenant')->with($sharedTenant)->andReturn(false);
        $user->shouldReceive('getDefaultTenant')->andReturn(null);
        $user->shouldReceive('getTenants')->andReturn(new Collection([]));

        $panel = $this->makePanel();
        $panel->shouldReceive('hasTenancy')->andReturn(true);
        $panel->shouldReceive('auth')->andReturn($this->makeGuard($user));
        $panel->shouldReceive('getTenant')->with('123')->andReturn($sharedTenant);
        Filament::shouldReceive('getCurrentOrDefaultPanel')->andReturn($panel);

        $this->middleware->handle($this->makeRequest(tenantKey: '123'), $this->next);

        $this->assertTrue($this->nextCalled);
    }

    private function makePanel(): Panel
    {
        return Mockery::mock(Panel::class)->makePartial();
    }

    private function makeGuard(?object $user): Guard
    {
        $guard = Mockery::mock(Guard::class);
        $guard->shouldReceive('user')->andReturn($user);

        return $guard;
    }

    private function makeTenant(string $routeKey): Model
    {
        $tenant = Mockery::mock(Model::class)->makePartial();
        $tenant->shouldReceive('getRouteKey')->andReturn($routeKey);

        return $tenant;
    }

    private function makeRequest(string $tenantKey, string $routeName = 'filament.general.pages.dashboard'): Request
    {
        $route = Mockery::mock(Route::class);
        $route->shouldReceive('hasParameter')->with('tenant')->andReturn(true);
        $route->shouldReceive('parameter')->with('tenant')->andReturn($tenantKey);
        $route->shouldReceive('getName')->andReturn($routeName);
        $route->shouldReceive('parameters')->andReturn(['tenant' => $tenantKey]);

        $request = Mockery::mock(Request::class);
        $request->shouldReceive('route')->withNoArgs()->andReturn($route);

        return $request;
    }
}
