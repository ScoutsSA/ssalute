# Ssalute — Feature Comparison & Project Plan
> Generated: 2026-03-05 | Last updated: 2026-03-05 by comparing scouts-digital (legacy) with ssalute (new)

---

## Summary

The legacy **Scouts Digital** system is a raw PHP application (~400+ files, no framework) covering the
complete lifecycle of Scouts South Africa membership — from recruitment through to retirement, including
group management, financials, events, training, reporting, and more.

**Ssalute** is currently in very early development. The infrastructure and first module (AAM) are being
built. Roughly 3–5% of legacy functionality has been re-implemented so far.

---

## Legend

| Symbol | Meaning |
|--------|---------|
| DONE | Built and working in Ssalute |
| WIP | In progress / partially scaffolded |
| PLANNED | Not yet started |
| NEW | New functionality that doesn't exist in legacy |
| SKIP | Intentionally out of scope |

---

## Module Breakdown

### 1. Infrastructure & Platform
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Authentication (login/logout/session) | Raw PHP sessions | Laravel Auth + Filament | DONE |
| Multi-role user support | Custom session logic | Filament tenancy (role ID in URL) | DONE |
| Role switching | admin-roles-switch.php | Filament built-in tenant switcher sidebar | DONE |
| User impersonation (admin) | admin-roles-switch.php | stechstudio/filament-impersonate | DONE |
| Multi-panel architecture | Single codebase, role-based redirects | Admin panel + General panel (Filament) | DONE |
| Cross-user shared link handling | N/A | RedirectToValidTenant middleware | DONE |
| Scheduled/cron jobs | cron/ directory (daily, hourly, weekly, monthly) | Laravel Horizon + Scheduler | DONE (infra) |
| Notifications | Custom DB table | Laravel Notifications + DB | DONE (infra) |
| Queue/async processing | None | Horizon | DONE (infra) |
| Email delivery | PHPMailer | SES + Laravel Mail | DONE (infra) |
| Error tracking | None | Sentry | DONE |
| Monitoring | None | Nightwatch + CloudWatch | DONE |
| Slack alerts | None | spatie/laravel-slack-alerts | DONE |
| PWA / Mobile | Basic PWA (serviceWorker.js, manifest.json) | Not started | PLANNED |
| Telegram bot | telegram-bot.php | Not started | PLANNED |
| Rate limiting | None | danharrin/livewire-rate-limiting installed | DONE (infra) |
| Settings management | includes/settings.php | spatie/laravel-settings (GeneralSettings, FormSettings) | DONE |
| API | Minimal (API/ dir) | Not started | PLANNED |
| Automated testing | None | PHPUnit — feature + unit tests | DONE (infra) |

---

### 2. User & Role Management
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| User listing/search | admin-roles.php | UserResource (Filament admin) | WIP |
| User profile | user-profile.php | Not started | PLANNED |
| Profile picture | user-profile-picture.php | Not started | PLANNED |
| Email settings | user-email-settings.php | Not started | PLANNED |
| Password change | user-password-change.php | Laravel default | DONE |
| User notifications | user-notifications.php | Not started | PLANNED |
| Redact/POPIA removal | user-redact-info.php | Not started | PLANNED |
| Role type management | admin-roles*.php | RoleResource (Filament admin) | WIP |
| Role assignment per user | ams-adult-role-*.php | Not started (general panel context) | PLANNED |
| User impersonation | admin-roles-switch.php | stechstudio/filament-impersonate | DONE |
| Role-based access (general panel) | Per-role PHP checks | canAccessPanel() + hasAnyActiveRole() | DONE |
| Role-based dashboards (per section) | 13 dashboards | General panel (single), section panels future | PLANNED |
| Any-role access to general panel | Management-only in legacy | Any active role can access | DONE |
| Phone number validation | None | giggsey/libphonenumber-for-php installed | DONE (infra) |

---

### 3. Adult Membership Application (AAM) — NEW MODULE
> This is a new workflow that doesn't exist in legacy (legacy assumed members were already in the system).

| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Public application form | None | Forms cluster, AAM resource | WIP |
| Email routing (group/district/regional/national) | None | FormSettings config-driven | DONE |
| Application review (top-level admin) | None | ApplicationAdultMembershipRequests resource | WIP |
| Applicant to User conversion | None | Not started | PLANNED |

---

### 4. Adult Member System (AMS)
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Add adult member | ams-adult-add.php | Not started | PLANNED |
| Edit adult member | ams-adult-edit.php | Not started | PLANNED |
| View all adult info | ams-adult-all-info.php | Not started | PLANNED |
| Manage active members | ams-adult-manage.php | Not started | PLANNED |
| Manage inactive members | ams-adult-manage-inactive.php | Not started | PLANNED |
| Activate member | ams-adult-activate.php | Not started | PLANNED |
| Move member between groups | ams-adult-move.php | Not started | PLANNED |
| Resign member | ams-adult-resign.php | Not started | PLANNED |
| Retire member | ams-adult-retire.php | Not started | PLANNED |
| Suspend member | ams-adult-suspend.php + ams-adult-suspended.php + undo | Not started | PLANNED |
| Terminate member | ams-adult-terminate.php | Not started | PLANNED |
| Gone home (deceased) | ams-adult-gone-home.php | Not started | PLANNED |
| Role management per member | ams-adult-role-*.php (add, disable, make primary) | Not started | PLANNED |
| Police clearance | national-reports-police-clearance*.php | Not started | PLANNED |
| Criminal check | AmsCriminalCheck model | Not started | PLANNED |
| Document requirements explanation | ams-adult-documents-explanation.php | Not started | PLANNED |

---

### 5. Warrants
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Add warrant | ams-warrant-add-start.php, ams-warrant-add.php | Not started | PLANNED |
| Manage warrants (5 levels) | ams-warrant-manage-1..5.php | Not started | PLANNED |
| Cancel warrant | ams-warrant-cancel.php | Not started | PLANNED |
| Extend warrant | ams-warrant-extend.php | Not started | PLANNED |
| Disable warrant | ams-warrant-disable.php | Not started | PLANNED |
| View individual warrant | ams-warrant-view-individual.php | Not started | PLANNED |
| Warrant appointment letters | warrant-appointment-applicant.php, warrant-appointment-no.php, warrant-no.php | Not started | PLANNED |
| Warrants expiring cron | cron/warrantsExpiring.php | Not started | PLANNED |
| Reports: warrants | reports-warrants.php, reports-warrants-expiring.php | Not started | PLANNED |
| User warrant history | user-warrants.php | Not started | PLANNED |

---

### 6. Awards & Charges & Disciplinary
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Award management | ams-award-*.php | Not started | PLANNED |
| Charge management | ams-charge-*.php | Not started | PLANNED |
| Disciplinary management | ams-disciplinary-*.php | Not started | PLANNED |
| Service awards | ams-service-*.php | Not started | PLANNED |
| Past service | ams-past-training-add.php, user-past-service.php | Not started | PLANNED |

---

### 7. Training
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Book training (future) | ams-training-book.php, ams-training-book-course.php | Not started | PLANNED |
| View future training | ams-training-future.php, ams-training-future-group.php, ams-training-future-youth.php | Not started | PLANNED |
| Training management | ams-training-manage.php | Not started | PLANNED |
| Regional bookable courses | ams-training-regional-bookable-course-*.php | Not started | PLANNED |
| Standard course management | ams-training-regional-standard-course-*.php | Not started | PLANNED |
| Training locations | ams-training-regional-location-*.php | Not started | PLANNED |
| Training lecturers | ams-training-regional-course-lecturers.php | Not started | PLANNED |
| Training attendance | ams-training-regional-bookable-course-attendance.php | Not started | PLANNED |
| Training completion/certificates | ams-training-regional-bookable-course-completion.php | Not started | PLANNED |
| Training financial reports | ams-training-regional-report-financial.php | Not started | PLANNED |
| Upload POP for training | ams-training-upload-pop.php | Not started | PLANNED |
| Past training (user view) | user-past-training.php | Not started | PLANNED |
| Reports: training | reports-training.php, reports-training-future.php | Not started | PLANNED |

---

### 8. Group Management
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Add group | ams-group-add.php | Not started | PLANNED |
| Edit group | ams-group-edit.php | Not started | PLANNED |
| Manage groups | ams-group-manage.php | Not started | PLANNED |
| Group settings | group-settings.php | Not started | PLANNED |
| Group documents | ams-group-document-add.php, ams-group-documents.php | Not started | PLANNED |
| Group property management | ams-group-property.php, ams-report-property.php | Not started | PLANNED |
| Regionally managed groups | regionally-managed-groups.php | Not started | PLANNED |

---

### 9. Youth Management
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Add youth | group-youth-add.php | Not started | PLANNED |
| Edit youth | group-youth-edit.php | Not started | PLANNED |
| Manage active youth | group-youth-manage.php | Not started | PLANNED |
| Manage inactive youth | group-youth-manage-inactive.php | Not started | PLANNED |
| Disable youth | group-youth-disable.php | Not started | PLANNED |
| Move youth | group-youth-move.php | Not started | PLANNED |
| Multi-youth actions | group-youth-multi.php | Not started | PLANNED |
| Youth charges | group-youth-charges.php | Not started | PLANNED |
| Youth patrols/sixes | group-youth-patrols.php, group-cub-sixes.php | Not started | PLANNED |
| Youth picture | group-youth-picture.php | Not started | PLANNED |
| Green card | group-youth-green-card.php | Not started | PLANNED |
| Entsha (youth advancement move) | group-entsha-move*.php | Not started | PLANNED |
| Parent management | group-parent-*.php | Not started | PLANNED |
| Attendance | attendance.php, group-account-attendance.php | Not started | PLANNED |

---

### 10. Advancements & Badges
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Advancements (Meerkats, Cubs, Scouts, Rovers) | group-advancement*.php, advancement-*.php | Not started | PLANNED |
| Badges | group-badge*.php, group-badges.php | Not started | PLANNED |
| Admin advancements | admin-advancements.php, admin-all-advancements.php | Not started | PLANNED |
| Admin badges management | admin-badges*.php | Not started | PLANNED |
| Star awards | group-star-add.php, star-*.php | Not started | PLANNED |
| Reports: advancements | reports-youth-advancement.php, reports-youth-advancements.php | Not started | PLANNED |
| Reports: badges | reports-group-badges.php, reports-youth-badges.php | Not started | PLANNED |

---

### 11. District & Region & National Management
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Add/edit/manage district | ams-district-*.php | Area cluster (basic) | WIP |
| Super-district management | ams-district-super-manage.php | Not started | PLANNED |
| Add/edit/manage region | ams-region-*.php | Area cluster (basic) | WIP |
| National management | national/ | Not started | PLANNED |
| District reports | leftNav-districtReports.php, reports-group-district-parents-committee | Not started | PLANNED |
| Regional reports | leftNav-regionalReports.php | Not started | PLANNED |

---

### 12. Financial Management
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Group financial accounts | group-financial-account-*.php | Not started | PLANNED |
| Invoices (standard) | group-financial-account-invoice-*.php | Not started | PLANNED |
| Annual invoices (bulk generation) | group-financial-account-invoice-annual-*.php | Not started | PLANNED |
| Payments | group-financial-account-payment-*.php | Not started | PLANNED |
| Credit notes | group-financial-account-credit-note-*.php | Not started | PLANNED |
| Account transfers | group-financial-account-transfer-*.php | Not started | PLANNED |
| Financial statements | group-financial-account-statement.php | Not started | PLANNED |
| Fee setup | group-financial-setup-fees.php | Not started | PLANNED |
| Financial years setup | group-financial-setup-financial-years.php | Not started | PLANNED |
| Financial reports | reports-group-financial-*.php | Not started | PLANNED |
| Training financial reports | ams-training-regional-report-financial.php | Not started | PLANNED |
| Group invoices (separate) | group-invoice-add.php, group-invoice-manage.php | Not started | PLANNED |
| Youth charges | group-youth-charges.php | Not started | PLANNED |

---

### 13. Events System
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Add/edit event | event-add.php, event-edit.php | Not started | PLANNED |
| Manage events | event-manage.php | Not started | PLANNED |
| Group attending management | event-manage-group-attending*.php | Not started | PLANNED |
| Event dashboard | event-dashboard.php | Not started | PLANNED |
| Event bookings (user) | event-bookings-user-*.php | Not started | PLANNED |
| Event bookings admin | event-bookings-admin-*.php (accommodation, invoices, payments, credit notes, patrols, transport, roles, reports) | Not started | PLANNED |
| Competition system | event-competition-*.php (scoring, leaderboards, GPS tracking, financial, survey) | Not started | PLANNED |
| Group calendar | calendar.php | Not started | PLANNED |
| Group holiday | group-holiday-add.php | Not started | PLANNED |
| Gauteng Kontiki | event-gauteng-kontiki-register.php | SKIP |

---

### 14. Programs
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Add/edit/manage programs | group-program-*.php | Not started | PLANNED |
| Program sharing | group-program-share.php, shared-programs*.php | Not started | PLANNED |
| Online programs | online-programs*.php (tasks, leaderboard, completion) | Not started | PLANNED |
| Program documents | group-program-document-upload.php | Not started | PLANNED |
| Program attendance | group-program-attendance-online.php | Not started | PLANNED |

---

### 15. Reports
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Census reports | reports-census*.php, national-reports-census*.php, census/ | Not started | PLANNED |
| Warrant reports | reports-warrants*.php | Not started | PLANNED |
| Advancement reports | reports-youth-*.php | Not started | PLANNED |
| Adult reports | reports-adults-*.php, reports-adult-*.php | Not started | PLANNED |
| Group in crisis | reports-groups-in-crisis*.php | Not started | PLANNED |
| Property reports | reports-property-all.php | Not started | PLANNED |
| Star award reports | reports-star.php | Not started | PLANNED |
| Badge reports | reports-badges*.php | Not started | PLANNED |
| Training reports | reports-training*.php | Not started | PLANNED |
| Financial reports | reports-group-financial-*.php | Not started | PLANNED |
| Admin reports | admin-reports-*.php (logons, roles, 404s, hacking detection) | Not started | PLANNED |
| Form 29 | national-reports-form29*.php, regenerateForm29.php | Not started | PLANNED |
| Police clearance | national-reports-police-clearance*.php | Not started | PLANNED |
| Emergency contacts | reports-group-emergency-contacts.php | Not started | PLANNED |
| Orphaned/vulnerable youth | reports-orphaned-vulnerable.php | Not started | PLANNED |
| Excel export | Throughout (PhpSpreadsheet) | Not started | PLANNED |
| PDF generation | Throughout (TCPDF) | Not started | PLANNED |
| iCal generation | ical/ | Not started | PLANNED |

---

### 16. Directories
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Group directory | directory-group*.php | Not started | PLANNED |
| District directory | directory-district*.php | Not started | PLANNED |
| Regional directory | directory-regional*.php | Not started | PLANNED |
| National directory | directory-national.php | Not started | PLANNED |
| Alumni directory | directory-alumni.php | Not started | PLANNED |
| Professional directory | directory-professional*.php | Not started | PLANNED |
| Scouter reviews | scouter-reviews*.php | Not started | PLANNED |
| Search | search.php | Not started | PLANNED |

---

### 17. Content & Community
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Articles/news | articles*.php, admin-articles*.php | Not started | PLANNED |
| Info sharing | info-sharing*.php, admin-info-sharing*.php | Not started | PLANNED |
| FAQ | faq*.php, admin-faq*.php | Not started | PLANNED |
| Projects | projects*.php, admin-projects*.php | Not started | PLANNED |
| Downloads page | downloads-page.php, downloads/ | Not started | PLANNED |
| Roadmap | roadmap*.php, admin-roadmap-little*.php | Not started | PLANNED |
| Group newsletters | group-newsletter-manage.php | Not started | PLANNED |
| Group meeting minutes | group-minutes-manage.php | Not started | PLANNED |
| Group committee | group-committee-*.php | Not started | PLANNED |
| Group council (Rovers) | group-council-*.php | Not started | PLANNED |

---

### 18. Equipment Management
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Add/edit/manage equipment | group-equipment-*.php | Not started | PLANNED |
| Equipment locations | group-equipment-locations.php | Not started | PLANNED |

---

### 19. Shop
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Group shop | shop-group.php | Not started | PLANNED |
| Shop cart | shop-cart.php | Not started | PLANNED |
| Shop wallet | shop-wallet.php | Not started | PLANNED |
| Wish list | shop-wish-list.php | Not started | PLANNED |
| Pay fees via shop | shop-pay-fees.php | Not started | PLANNED |
| Admin shop categories | admin-shop-category*.php | Not started | PLANNED |

---

### 20. Census
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Annual census (group/district/regional/national) | census/*.php | Not started | PLANNED |
| Census notifications cron | cron/censusNotifications.php | Not started | PLANNED |
| Census reports | reports-census*.php | Not started | PLANNED |

---

### 21. Support
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Support tickets/chat | support-add.php, support-chat.php, support-log-admin.php | Not started | PLANNED |

---

### 22. Special / One-Off
| Feature | Legacy | Ssalute | Status |
|---------|--------|---------|--------|
| Jamboree (SANJAMB) | sanjamb-*.php | Not started | PLANNED |
| WSM16 | wsm16-*.php | SKIP (past event) |
| 24WSJ | dashboard-24WSJ.php | SKIP (past event) |

---

## Recommended Build Order (Phased Plan)

### Phase 1 — Foundation (Current / Near-term)
> Get the core of member management working. Nothing else matters without this.

1. ~~**Multi-panel architecture**~~ — Admin + General panels with Filament tenancy ✅ DONE
2. ~~**Role-based access control**~~ — Any active role can access the general panel; super-admin gated admin panel ✅ DONE
3. ~~**Role switcher in URL**~~ — Filament tenancy embeds role attachment ID in every URL, built-in sidebar switcher ✅ DONE
4. ~~**Shared link redirect**~~ — RedirectToValidTenant middleware safely redirects cross-user shared links ✅ DONE
5. ~~**Automated test infrastructure**~~ — PHPUnit, SdCoreTestCase, factories, feature tests for both panels ✅ DONE
6. **Authentication — profile, password reset, email verification** — proper self-service flows
7. **Area hierarchy browsing** — Groups → Districts → Regions → National (view + basic management)
8. **AAM (Adult Application for Membership)** — complete the current WIP; this is the entry point for new adults _(in progress)_

### Phase 2 — Adult Member Lifecycle
> Once someone is in the system, manage them through their Scouts journey.

5. **AMS core** — add, edit, view, activate, manage inactive adults
6. **Warrants** — add, manage (5 levels), cancel, extend, expiry notifications
7. **Awards** — service awards add/manage
8. **Past service & charges** — basic tracking
9. **Role management per member** — assign/remove/primary roles

### Phase 3 — Group Operations
> Give group leaders the tools they need day to day.

10. **Youth management** — add, edit, move, patrols/sixes/dens/crews
11. **Parent management** — link parents to youth
12. **Attendance** — weekly attendance tracking
13. **Programs** — add, manage, share programs
14. **Committee & Council management**

### Phase 4 — Advancements & Badges
15. **Advancements** — Meerkat, Cub, Scout, Rover tracks
16. **Badges** — task sign-off, purchase reporting
17. **Star awards**
18. **Entsha program**

### Phase 5 — Training
19. **Regional training** — courses, locations, lecturers, bookings, attendance, completion
20. **Individual training history** — view/upload POP
21. **Training reports**

### Phase 6 — Financial Management
22. **Group financial accounts** — setup, invoices, payments, credit notes
23. **Annual invoice generation** (bulk)
24. **Financial statements & reports**
25. **Account transfers** between groups

### Phase 7 — Reporting & Census
26. **Core reports** — warrants, adults, youth numbers, groups in crisis
27. **Census** — annual group/district/regional/national census
28. **Form 29** — generation and tracking
29. **Police clearance** tracking
30. **Excel/PDF export** throughout

### Phase 8 — Events & Competitions
31. **Events** — add/manage, group attending, booking system
32. **Event financials** — invoices, payments, credit notes
33. **Competition system** — scoring, leaderboards
34. **Calendar integration** (iCal)

### Phase 9 — Content & Community
35. **Articles/News**
36. **Info sharing**
37. **FAQ**
38. **Downloads**
39. **Directories** (group, district, regional, national, professional)
40. **Roadmap** (public-facing)

### Phase 10 — Advanced & Legacy Parity
41. **Shop** (fees payment, wallet, products)
42. **Support/chat system**
43. **Online programs** with leaderboards
44. **PWA / Mobile** support
45. **Telegram bot**
46. **API** (external integrations)
47. **Admin tooling** — role reports, logon reports, hacking detection

---

## Notes on Architecture Differences

| Concern | Legacy | Ssalute |
|---------|--------|---------|
| Auth | Custom session PHP | Laravel Auth (secure, tested) |
| Permissions | Ad-hoc session checks in each file | Policy/Gate system (to be built) |
| DB access | Raw SQL in every file | Eloquent ORM + Models |
| Email | PHPMailer, inline | Laravel Mail + SES queued |
| File uploads | Local disk, flat storage | Laravel Storage, S3-compatible |
| PDF | TCPDF inline | To be decided (TCPDF/Browsershot/DomPDF) |
| Excel | PHPSpreadsheet inline | Laravel Excel or OpenSpout |
| Cron | Server crontab calling PHP files | Laravel Scheduler + Horizon queues |
| Security | Manual, inconsistent | CSRF, XSS, SQL injection protection built-in |
| Testing | None | PHPUnit (Filament feature tests) |
| Deployments | Manual FTP | Laravel Forge CI/CD |

---

## Current Completion Estimate
- **Infrastructure:** ~90% ready for building features
- **Feature parity with legacy:** ~5–7%
- **New features (AAM onboarding flow):** ~40% complete

## Architecture Decisions Log

| Decision | Rationale |
|----------|-----------|
| Filament tenancy for role switching | Embeds role context in URL — shareable, bookmarkable, no hidden session state |
| Single `general` panel for all roles | Avoids panel proliferation; role-specific dashboards can be built within using tenant context |
| `SystemUsersOtherRole` as the Filament tenant | Each role attachment is a tenant; user can switch between their active roles |
| `RedirectToValidTenant` middleware | Handles shared links gracefully without 404; placed before `IdentifyTenant` in middleware stack |
| `hasAnyActiveRole()` for panel access | Any user with at least one active role can use the general panel — not just management-level roles |
| SQLite-compatible test migration | Legacy sd_v2 migrations use non-unique index names (valid in MySQL, invalid in SQLite); test-only migration creates the minimal schema needed |
| `SdCoreTestCase` for feature tests | Encapsulates `RefreshDatabase` + correct `migrateFreshUsing()` override so feature tests can use sd-core tables |
