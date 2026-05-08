# Business Requirements Document — Ssalute
## Scouts South Africa Member Management System

**Version:** 1.1
**Date:** 2026-04-16
**Status:** Living document — updated as each phase is delivered

---

## 1. Executive Summary

Ssalute is a modern, framework-based rewrite of **Scouts Digital** — the internal member management system for Scouts South Africa. The legacy system is a raw PHP application (~400+ files, no framework, no test coverage) that has accumulated significant technical debt over many years. It covers the complete lifecycle of Scouts SA membership from recruitment and adult onboarding through to retirement, group management, financials, events, training, reporting, and beyond.

Ssalute replaces this with a clean Laravel application backed by Filament v5, PHPUnit test coverage from day one, queued async processing via Horizon, and a structured architecture that can be maintained, extended, and deployed with confidence.

The new system maintains full data compatibility with the existing `sd-core` database schema so that migration can happen incrementally with zero data loss.

---

## 2. Scope

### 2.1 In Scope

| Dimension | Detail                                                                                                                              |
|-----------|-------------------------------------------------------------------------------------------------------------------------------------|
| **Data layer** | Full compatibility with the existing MySQL `sd-core` database (291 Eloquent models)                                                 |
| **Functional coverage** | 20+ modules covering all major areas of the legacy system (see Section 8)                                                           |
| **Admin backoffice panel** | Filament v5 admin panel for super admins and national-level staff at `/backoffice`                                                  |
| **Member panel** | Filament v5 member panel for all active role holders at `/member/{tenant}`                                                          |
| **Holding zone panel** | Temporary Filament v5 fallback panel for authenticated users without active roles or valid warrants/appointments at `/holding-zone` |
| **Authentication** | Laravel Auth — login, logout, password reset, email verification                                                                    |
| **Multi-role support** | Filament tenancy — one user can hold multiple roles across different geographic levels                                              |
| **Infrastructure** | Horizon queues, Laravel Scheduler, SES email, Sentry error tracking, Nightwatch monitoring                                          |
| **Testing** | PHPUnit feature tests using `SdCoreTestCase` for all features                                                                       |

### 2.2 Out of Scope

| Item                                  | Reason                                                                  |
|---------------------------------------|-------------------------------------------------------------------------|
| **WSM16** (World Scout Moot 2016)     | Past event; no ongoing operational need                                 |
| **24WSJ** (24th World Scout Jamboree) | Past event; legacy dashboard to be retired                              |
| **Gauteng Kontiki**                   | Regional-specific one-off event; not a national platform concern        |
| **Shop**                              | Legacy references to a potential on-platform shop                       |
| **Payment Tiers**                     | Legacy references to "paid" groups and tiering                          |
| **Telegram bot**                      | Legacy references to telegram bot                                       |
| **External API**                      | Planned future feature; not in current phases                           |
| **External MCP Server**               | Planned future feature; not in current phases                           |
| **AI Documentation & Policy Helper**  | Planned future feature; not in current phases                           |
| **Permit System**                     | Planned future migration from an external system; not in current phases |
| **Minor Consent Form Overhaul**       | Planned future feature; not in current phases |
| **Whatsapp & SMS Integrations**       | Planned future feature; not in current phases |
| **PWA / Mobile app**                  | Planned future feature; not in current phases                           |

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
| **Super Admin** | Admin + Member | System administrators; can access all backoffice functions. Identified by `super_user_admin_list` in `GeneralSettings` or by config `ssalute.superuser_email`. |
| **National Commissioner / Staff** | Admin (limited) + Member | National-level role holders with `canAdminNational = 1` on their `SystemUserType`. Access to national-scoped reports and management. |
| **Regional Commissioner / Admins** | Member | Regional-level roles (`regionalRole = 1`). Manage groups and adults within their region. |
| **District Commissioner / Admins** | Member | District-level roles (`districtRole = 1`). Manage groups and adults within their district. |
| **Group Leader / Scouter (warranted)** | Member | Group-level roles (`groupRole = 1`, `warrantedRole = 1`). Manage youth, programs, and group operations. |
| **Group Admin** | Member | Group-level administrative roles. Manage invoices, communications, and administrative tasks for the group. |
| **Parent / Parent Helper** | Member | `parentHelperRole = 1`. Read-limited access to youth information for their own children. |
| **Youth (read-only)** | Member (future) | Youth members in Meerkat/Cub/Scout/Rover sections. Read-only access to personal advancement records. |
| **Alumni** | Member | `alumniRole = 1`. Read-only access to own historical records. |
| **Holding Zone User** | Holding Zone | Authenticated users without active warrants or appointments. Redirected here by `EnsureValidWarrant` middleware until their role attachments are valid. |

---

## 4. System Panels

### 4.1 Admin Backoffice Panel (`/backoffice`)

Accessible only to super admins. Provides a global view across all geographic levels without tenant scoping.

**Purpose:** System administration, data corrections, lookup table management, national-level reporting, and backoffice operations that should not be exposed to field-level operators.

### 4.2 Member Panel (`/member/{tenant}`)

Accessible to any user with at least one active role that has a valid warrant or appointment. The panel is tenant-aware, where each role attachment a user holds is a separate tenant. The tenant ID is embedded in the URL, making every page bookmarkable and shareable. Users switch between their roles via the sidebar tenant switcher. Shared links are handled gracefully by redirecting to the recipient's equivalent context rather than returning a 404.

**Purpose:** Day-to-day operations for all active role holders, including profile management, youth management, group operations, training bookings, event attendance, and more.

### 4.3 Holding Zone Panel (`/holding-zone`)

Accessible to any authenticated user. Serves as a fallback for users who do not currently have any active roles with valid warrants or appointments. Users are redirected here automatically if their role's warrant or appointment is invalid.

The panel provides limited functionality: profile viewing and editing, password change, and informational notices explaining why the user's access is restricted.

**Purpose:** A safe landing area for authenticated users whose roles lack valid warrants or appointments, keeping them informed of their status while preventing access to operational features.

---

## 5. Current State

| Dimension | Status                                                                                                                |
|-----------|-----------------------------------------------------------------------------------------------------------------------|
| **Infrastructure** | ~90% complete — Auth, panels, tenancy, queues, email, error tracking, testing infrastructure all in place             |
| **Feature parity with legacy** | ~5% — My Profile and Tenant switcher logic all in place                                                               |
| **Test coverage** | Feature tests in place for admin panel access, member panel access, area cluster, settings|

---

## 6. Technology Decisions

| Decision | Detail | Rationale                                                                              |
|----------|--------|----------------------------------------------------------------------------------------|
| **Laravel 12 + PHP 8.4** | Core framework | Modern, well-supported, security-maintained                                            |
| **Filament v5** | Admin and member panels | Rich component library; inbuilt tenancy, impersonation, form/table/infolist components |
| **Filament tenancy for role switching** | One panel, role context in URL | Bookmarkable, shareable, no hidden session state; avoids panel proliferation           |
| **Filament clusters** | One cluster per module | Groups related resources in the sidebar; maps cleanly to legacy module boundaries      |
| **spatie/laravel-settings** | Strongly-typed settings stored in DB | Editable in the backoffice UI without code changes                                     |
| **Horizon** | Queue worker | Manages all queued jobs (email sends, report generation, notifications)                |
| **SES + Laravel Mail** | Email delivery | Replaces legacy PHPMailer; queued, retryable                                           |
| **Sentry + Nightwatch** | Error tracking and monitoring | No equivalent existed in legacy                                                        |

---

## 7. Architecture

### 7.1 Geography Hierarchy

```
National
  └── Region (province-level)
        └── (Super District — optional grouping)
              └── District
                    └── Group
                          ├── Meerkat Den
                          ├── Cub Pack
                          ├── Scout Troop
                          └── Rover Crew
```

### 7.2 Adult Member Lifecycle

The adult member lifecycle covers recruitment, onboarding, active membership, and exit. The exact onboarding workflow (Adult Application for Membership) is still being planned and specified (see [docs/features/10-aam.md](features/10-aam.md)). At a high level, the lifecycle includes:

- **Onboarding:** application, approval, member record creation, role assignment, warrant issuance (workflow TBD)
- **Active membership:** training, awards, police clearance, document management
- **Exit:** resign, retire, terminate, or suspend

### 7.3 Financial Model

Each group maintains one or more financial accounts. Financial activity is tracked through invoices, payments, credit notes, fees, and inter-group transfers. Annual invoice generation creates bulk invoices for all groups in a financial year.

---

## 8. Module List

The following modules are planned for Ssalute. Each has a dedicated feature folder containing an `overview.md` (business requirements) and a `technical.md` (implementation details).

| # | Module | Status | Feature Spec |
|---|--------|--------|-------------|
| 1 | Adult Member System (AMS) | Planned | [features/01-adult-member-system/overview.md](features/01-adult-member-system/overview.md) |
| 2 | Warrants | Scaffolded (list/view) | [features/02-warrants/overview.md](features/02-warrants/overview.md) |
| 3 | Youth Management | Planned | [features/03-youth-management/overview.md](features/03-youth-management/overview.md) |
| 4 | Advancements & Badges | Planned | [features/04-advancements-badges/overview.md](features/04-advancements-badges/overview.md) |
| 5 | Training | Scaffolded (list) | [features/05-training/overview.md](features/05-training/overview.md) |
| 6 | Financial Management | Planned | [features/06-financial-management/overview.md](features/06-financial-management/overview.md) |
| 7 | Events & Competitions | Planned | [features/07-events-competitions/overview.md](features/07-events-competitions/overview.md) |
| 8 | Group Operations | Planned | [features/08-group-operations/overview.md](features/08-group-operations/overview.md) |
| 9 | Reports & Census | Planned | [features/09-reports-census/overview.md](features/09-reports-census/overview.md) |
| 10 | Adult Application for Membership (AAM) | WIP (~40%) | [features/10-aam/overview.md](features/10-aam/overview.md) |
| 11 | Area Management (Districts/Regions) | WIP (basic) | [features/11-area-management/overview.md](features/11-area-management/overview.md) |
| 12 | Content & Community | Planned | [features/12-content-community/overview.md](features/12-content-community/overview.md) |
| 13 | Support & Ticketing | Planned | Not yet documented |

---

## 9. Testing Strategy

All features must have PHPUnit feature tests. Each module must test:

- **Happy paths** — the feature works correctly for authorised users
- **Forbidden paths** — unauthorised users receive `403 Forbidden` or are redirected
- **Guest paths** — unauthenticated users are redirected to login
- **Validation failures** — invalid form submissions return appropriate errors
- **Edge cases** — boundary conditions specific to the business logic

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
