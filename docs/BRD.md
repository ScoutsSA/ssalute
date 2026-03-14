# Business Requirements Document — Ssalute
## Scouts South Africa Member Management System

**Version:** 1.0
**Date:** 2026-03-13
**Status:** Living document — updated as each phase is delivered

---

## 1. Executive Summary

Ssalute is a modern, framework-based rewrite of **Scouts Digital** — the internal member management system for Scouts South Africa. The legacy system is a raw PHP application (~400+ files, no framework, no test coverage) that has accumulated significant technical debt over many years. It covers the complete lifecycle of Scouts SA membership from recruitment and adult onboarding through to retirement, group management, financials, events, training, reporting, and beyond.

Ssalute replaces this with a clean Laravel 12 application backed by Filament v4, PHPUnit test coverage from day one, queued async processing via Horizon, and a structured architecture that can be maintained, extended, and deployed with confidence.

The new system maintains full data compatibility with the existing `sd-core` database schema so that migration can happen incrementally with zero data loss.

---

## 2. Scope

### 2.1 In Scope

| Dimension | Detail |
|-----------|--------|
| **Data layer** | Full compatibility with the existing MySQL `sd-core` database (291 Eloquent models) |
| **Functional coverage** | 20+ modules covering all major areas of the legacy system (see Section 8) |
| **Admin backoffice panel** | Filament v4 admin panel for super admins and national-level staff at `/backoffice` |
| **General member panel** | Filament v4 general panel for all active role holders at `/general/{tenant}` |
| **Authentication** | Laravel Auth — login, logout, password reset, email verification |
| **Multi-role support** | Filament tenancy — one user can hold multiple roles across different geographic levels |
| **Infrastructure** | Horizon queues, Laravel Scheduler, SES email, Sentry error tracking, Nightwatch monitoring |
| **Testing** | PHPUnit feature tests using `SdCoreTestCase` for all features |

### 2.2 Out of Scope

| Item | Reason |
|------|--------|
| **WSM16** (World Scout Moot 2016) | Past event; no ongoing operational need |
| **24WSJ** (24th World Scout Jamboree) | Past event; legacy dashboard to be retired |
| **Gauteng Kontiki** | Regional-specific one-off event; not a national platform concern |
| **Telegram bot** | Planned future feature; not in current phases |
| **External API** | Planned future feature; not in current phases |
| **PWA / Mobile app** | Planned future feature; not in current phases |

---

## 3. Stakeholders

### 3.1 Role Hierarchy

Scouts South Africa has a strict geographic hierarchy. Roles exist at each level and permissions cascade downward:

```
National
  └── Region (province-level)
        └── (Super District — optional grouping)
              └── District
                    └── Group
                          ├── Den (Meerkats)
                          ├── Pack (Cubs)
                          ├── Troop (Scouts)
                          └── Crew (Rovers)
```

### 3.2 Stakeholder Profiles

| Stakeholder | Panel Access | Description |
|-------------|-------------|-------------|
| **Super Admin** | Admin + General | System administrators; can access all backoffice functions. Identified by `super_user_admin_list` in `GeneralSettings` or by config `ssalute.superuser_email`. |
| **National Commissioner / Staff** | Admin (limited) + General | National-level role holders with `canAdminNational = 1` on their `SystemUserType`. Access to national-scoped reports and management. |
| **Regional Commissioner / Admins** | General | Regional-level roles (`regionalRole = 1`). Manage groups and adults within their region. |
| **District Commissioner / Admins** | General | District-level roles (`districtRole = 1`). Manage groups and adults within their district. |
| **Group Leader / Scouter (warranted)** | General | Group-level roles (`groupRole = 1`, `warrantedRole = 1`). Manage youth, programs, and group operations. |
| **Group Admin** | General | Group-level administrative roles. Manage invoices, communications, and administrative tasks for the group. |
| **Parent / Parent Helper** | General | `parentHelperRole = 1`. Read-limited access to youth information for their own children. |
| **Youth (read-only)** | General (future) | Youth members in Meerkat/Cub/Scout/Rover sections. Read-only access to personal advancement records. |
| **Alumni** | General | `alumniRole = 1`. Read-only access to own historical records. |

---

## 4. System Panels

### 4.1 Admin Backoffice Panel (`/backoffice`)

The admin panel is a Filament v4 panel provided by `AdminPanelProvider`. It is accessible only to users who pass `canAccessPanel()` on `SystemUser` — currently restricted to super admins (by `GeneralSettings::super_user_admin_list` or by configured superuser email).

This panel is **not tenant-aware**; it provides a global view across all geographic levels.

**Purpose:** System administration, data corrections, lookup table management, national-level reporting, and backoffice operations that should not be exposed to field-level operators.

### 4.2 General Member Panel (`/general/{tenant}`)

The general panel is a Filament v4 tenant-aware panel provided by `GeneralPanelProvider`. The tenant model is `SystemUsersOtherRole` — each role attachment a user holds is a separate "tenant" in Filament terms. The tenant ID is embedded in the URL, making every page bookmarkable and shareable.

Users switch between their roles via the built-in Filament sidebar tenant switcher. The `RedirectToValidTenant` middleware handles shared links gracefully, redirecting to the recipient's equivalent context rather than returning a 404.

**Purpose:** Day-to-day operations for all active role holders — profile management, youth management, group operations, training bookings, event attendance, and more.

---

## 5. Current State

| Dimension | Status |
|-----------|--------|
| **Infrastructure** | ~90% complete — Auth, panels, tenancy, queues, email, error tracking, testing infrastructure all in place |
| **Feature parity with legacy** | ~5–7% — AAM onboarding flow ~40% complete; AMS cluster scaffolded with lookup tables and basic resources |
| **Test coverage** | Feature tests in place for admin panel access, general panel access, AMS cluster, area cluster, settings, and AAM form |

---

## 6. Technology Decisions

| Decision | Detail | Rationale |
|----------|--------|-----------|
| **Laravel 12 + PHP 8.4** | Core framework | Modern, well-supported, security-maintained |
| **Filament v4** | Admin and general panels | Rich component library; inbuilt tenancy, impersonation, form/table/infolist components |
| **Filament tenancy for role switching** | `SystemUsersOtherRole` as the tenant model | Role context is embedded in the URL — bookmarkable, shareable, no hidden session state |
| **Single general panel** | All roles use one panel at `/general/{tenant}` | Avoids panel proliferation; role-specific content is gated within the panel using tenant context |
| **Filament clusters** | One cluster per module (AMS, Area, Forms, Settings, etc.) | Groups related resources in the sidebar; maps cleanly to legacy module boundaries |
| **spatie/laravel-settings** | `GeneralSettings`, `FormSettings` | Strongly-typed settings stored in DB; editable in the admin UI without code changes |
| **SdCoreTestCase** | Base class for feature tests | Handles the `sd-core` schema dump + Ssalute migrations; `RefreshDatabase` for test isolation |
| **`actingAs(superAdmin)` pattern** | Standard test auth pattern | Matches how Filament resolves `canAccessPanel()` in tests |
| **`hasAnyActiveRole()`** | General panel access check | Any user with at least one active `SystemUsersOtherRole` can access the general panel |
| **Horizon** | Queue worker | Manages all queued jobs (email sends, report generation, cron-triggered notifications) |
| **SES + Laravel Mail** | Email delivery | Replaces legacy PHPMailer; queued, retryable |
| **Sentry + Nightwatch** | Error tracking and monitoring | No equivalent existed in legacy |

---

## 7. Architecture

### 7.1 Geography Hierarchy

```
National (National model)
  └── Region (Region model) — province-level
        └── DistrictsSuper (DistrictsSuper model) — optional super-district grouping
              └── District (District model)
                    └── Group (Group model)
                          ├── GroupMeerkatDen — Meerkat dens
                          ├── GroupCubPack — Cub packs
                          ├── GroupScoutTroop — Scout troops
                          └── GroupRoverCrew — Rover crews
```

### 7.2 Adult Member Lifecycle

```
AAM Application (AamsRequest)
  → Approval workflow (email routing via FormSettings)
  → Conversion to SystemUser
  → Role assignment (SystemUsersOtherRole)
  → Warrant issuance (AmsWarrantInfo)
  → Ongoing: training, awards, police clearance, documents
  → Exit: resign / retire / terminate / suspend (AmsResignLeader, AmsRetireLeader, etc.)
```

### 7.3 Financial Model

Each group has one or more `GroupAccount` records. Financial activity is tracked through:
- `GroupFinancialInvoice` / `GroupFinancialInvoicesItem`
- `GroupFinancialPaymentsMade`
- `GroupFinancialCreditNote` / `GroupFinancialCreditNotesItem`
- `GroupFinancialFee` / `GroupFinancialFeeType`
- `GroupFinancialYear`
- `GroupAccountsTransfer` (transfers between group accounts)

Annual invoice generation creates bulk invoices for all groups in a financial year.

### 7.4 Application Structure

```
app/
  Filament/
    Admin/
      Clusters/
        AMS/           — Adult Member System (warrants, awards, charges, discipline, training, police clearance, past service + lookups)
        Area/          — Geographic management (Districts, Regions, Groups)
        Forms/         — Public-facing forms (AAM application management)
        Settings/      — System configuration pages
        Advancements/  — (Planned) Youth advancement management
        GroupOperations/ — (Planned) Group management
      Resources/
        Users/         — SystemUser management (admin-level)
        Roles/         — SystemUserType management
    General/
      Pages/
        Dashboard      — Role-aware landing page
        ViewProfile    — Read-only profile (infolist-based)
        EditProfile    — Editable profile
  Models/              — 291 Eloquent models mapped to sd-core schema
  Settings/            — spatie/laravel-settings: GeneralSettings, FormSettings
  Providers/
    Filament/
      AdminPanelProvider
      GeneralPanelProvider
```

---

## 8. Module List

The following modules are planned for Ssalute. Each has a dedicated feature specification document.

| # | Module | Status | Feature Spec |
|---|--------|--------|-------------|
| 1 | Adult Member System (AMS) | Planned | [docs/features/01-adult-member-system.md](features/01-adult-member-system.md) |
| 2 | Warrants | Scaffolded (list/view) | [docs/features/02-warrants.md](features/02-warrants.md) |
| 3 | Youth Management | Planned | [docs/features/03-youth-management.md](features/03-youth-management.md) |
| 4 | Advancements & Badges | Planned | [docs/features/04-advancements-badges.md](features/04-advancements-badges.md) |
| 5 | Training | Scaffolded (list) | [docs/features/05-training.md](features/05-training.md) |
| 6 | Financial Management | Planned | [docs/features/06-financial-management.md](features/06-financial-management.md) |
| 7 | Events & Competitions | Planned | [docs/features/07-events-competitions.md](features/07-events-competitions.md) |
| 8 | Group Operations | Planned | [docs/features/08-group-operations.md](features/08-group-operations.md) |
| 9 | Reports & Census | Planned | [docs/features/09-reports-census.md](features/09-reports-census.md) |
| 10 | Adult Application for Membership (AAM) | WIP (~40%) | [docs/features/10-aam.md](features/10-aam.md) |
| 11 | Area Management (Districts/Regions) | WIP (basic) | [docs/features/11-area-management.md](features/11-area-management.md) |
| 12 | Content & Community | Planned | [docs/features/12-content-community.md](features/12-content-community.md) |
| 13 | Support & Ticketing | Planned | [docs/features/13-support.md](features/13-support.md) |
| 14 | Shop | Planned | [docs/features/14-shop.md](features/14-shop.md) |
| 15 | Jamboree | Planned | [docs/features/15-jamboree.md](features/15-jamboree.md) |

---

## 9. Testing Strategy

All features must have PHPUnit feature tests. The following conventions apply across the project:

### 9.1 Base Test Class

All feature tests that touch the `sd-core` database schema must extend `Tests\Support\SdCoreTestCase`. This class:

- Loads the `sd-core` MySQL schema dump on first run
- Applies Ssalute-specific migrations on top
- Uses `RefreshDatabase` (wraps each test in a transaction and rolls back)

Tests that do not touch the database may extend the base `Tests\TestCase` directly.

### 9.2 Auth Pattern

```php
// Super admin access
$superAdmin = SystemUser::factory()->create();
app(GeneralSettings::class)->fill(['super_user_admin_list' => [$superAdmin->id]])->save();
$this->actingAs($superAdmin)->get($url)->assertOk();

// Regular user with a role
$user = SystemUser::factory()->withRole()->create();
$this->actingAs($user)->get($url)->assertForbidden(); // for admin panel
```

### 9.3 Test Structure

Each module must test:
- **Happy paths** — the feature works correctly for authorised users
- **Forbidden paths** — unauthorised users receive `403 Forbidden` or are redirected
- **Guest paths** — unauthenticated users are redirected to login
- **Validation failures** — invalid form submissions return appropriate errors
- **Edge cases** — boundary conditions specific to the business logic

### 9.4 Running Tests

```bash
# Run all tests
php artisan test --compact

# Run a specific test file
php artisan test --compact tests/Feature/Filament/AmsClusterTest.php

# Filter by test name
php artisan test --compact --filter=super_admin_can_access
```

---

## 10. Deployment

- **Environment:** Laravel Forge managed server
- **CI/CD:** Automated deployments via Forge on push to main
- **Queue worker:** Horizon (supervisor-managed)
- **Cache / Session:** Redis
- **Database:** MySQL 8.4+
- **File storage:** Laravel Storage, S3-compatible backend
- **Email:** AWS SES via Laravel Mail (queued)
- **Error tracking:** Sentry
- **Monitoring:** Nightwatch + CloudWatch
- **Alerts:** spatie/laravel-slack-alerts
