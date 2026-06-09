---
name: adding-a-setting
description: "Use this skill whenever you add, change, or remove an application setting in this project. Covers spatie/laravel-settings (settings classes in app/Settings, migrations in database/settings), and exposing the setting in the BackOffice Filament panel (the super-user-only `admin` panel) via a SettingsPage in the SettingsCluster. Use it for new settings groups, new properties on an existing group, default values, casts, and the matching Filament form field. Do not use for generic Filament resources, config() values, or .env changes."
---

# Adding a Setting

This project stores application settings with `spatie/laravel-settings`. A setting has three parts that must stay in sync:

1. A typed property on a settings class in `app/Settings`.
2. A settings migration in `database/settings` that seeds the value.
3. A form field on a `SettingsPage` in the BackOffice Filament panel.

## 1. The settings class

Settings are grouped into classes extending `Spatie\LaravelSettings\Settings`, one file per group in `app/Settings`. Each public property is one setting; `group()` returns the group name used as the storage key prefix and in the `ssalute_settings` table.

```php
namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class DataFixesSettings extends Settings
{
    public bool $ensure_each_user_has_only_one_primary_role = true;

    public ?string $slack_webhook_url = null;

    public static function group(): string
    {
        return 'data_fixes';
    }
}
```

Conventions:

- Property names are `snake_case` (matches existing groups like `FeatureSettings`).
- Give every property a typed declaration. Use nullable types (`?string`, `?array`, `?int`) for optional values.
- The class is auto-discovered (`config/settings.php` → `auto_discover_settings` scans `app/Settings`). You do not register it manually.
- To add a property to an existing group, add the public property here AND a migration (step 2). Adding the property without a migration throws a `MissingSettings` exception at load time.

> Artisan generators: spatie ships `php artisan make:setting <Name>` to scaffold the settings class (step 1) and `php artisan make:settings-migration <name>` for the migration (step 2). The BackOffice page (step 3) can be scaffolded with `php artisan make:filament-settings-page --panel=admin`. Always pass `--no-interaction`.

## 2. The migration

Generate the migration with the spatie command rather than creating the file by hand. It writes a timestamped stub into `database/settings` (the first `migrations_paths` in `config/settings.php`):

```bash
php artisan make:settings-migration CreateDataFixesSettings --no-interaction
```

The generated stub returns an anonymous `SettingsMigration` class with empty `up()`. These run with `php artisan migrate`.

```php
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('data_fixes.ensure_each_user_has_only_one_primary_role', true);
        $this->migrator->add('data_fixes.slack_webhook_url', null);
    }
};
```

Notes:

- The migrator method is `add('group.property', $defaultValue)`. There is no `addNullable`; pass `null` as the default for nullable properties.
- To rename or delete, use `$this->migrator->rename(...)` / `->delete(...)` in a new migration. Never edit a migration that has already run; roll forward with a new one.
- Migrations are immutable once committed. Existing groups in this repo were evolved through many additive migrations (see `database/settings`).
- After writing the migration, run `php artisan migrate` so the row exists locally.

## 3. The Filament page (BackOffice panel only)

Settings are edited **only** in the BackOffice panel (panel id `admin`, path `/backoffice`), which is restricted to super-users by `SystemUser::isSuperAdmin()` (`general.super_user_admin_list` + `ssalute.superuser_email`). The Member and Holding Zone panels never expose settings.

Each settings group has one page under `app/Filament/Admin/Clusters/Settings/Pages`, in the `SettingsCluster`, extending `Filament\Pages\SettingsPage` and using the `AuditsSettings` concern (so changes land in the audit log).

```php
namespace App\Filament\Admin\Clusters\Settings\Pages;

use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Filament\Shared\Concerns\AuditsSettings;
use App\Settings\DataFixesSettings;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageDataFixesSettings extends SettingsPage
{
    use AuditsSettings;

    protected static string|null|BackedEnum $navigationIcon = Heroicon::Wrench;

    protected static string $settings = DataFixesSettings::class;

    protected static ?string $navigationLabel = 'Data Fixes';

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 4;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                Section::make('Fixes')
                    ->collapsible()
                    ->schema([
                        Toggle::make('ensure_each_user_has_only_one_primary_role')
                            ->label('Ensure each user has only one primary role')
                            ->helperText('...'),
                    ]),
            ]);
    }
}
```

Conventions:

- Form field names must exactly match the settings property names.
- `protected static string $settings` points at the settings class; Filament binds the form to it automatically.
- Sections must be `collapsible()` (project-wide convention). To add a field to an existing group, edit that group's existing page rather than creating a new one.
- For an entirely new group, add a new page with a unique `navigationSort` and an icon from the `Filament\Support\Icons\Heroicon` enum.
- Pick form components to match the type: `Toggle` (bool), `TextInput` (string, add `->url()`/`->password()->revealable()` for secrets), `Select`/`TagsInput` (arrays), `Select` with `->options(fn () => SystemUserType::active()...)` for role pickers. See `ManageGeneralSettings` and `ManageFeatureSettings` for worked examples.

## 4. Reading a setting in code

Resolve the settings class from the container; never read the `ssalute_settings` table directly.

```php
$webhook = app(\App\Settings\DataFixesSettings::class)->slack_webhook_url;
```

In console commands you can type-hint the settings class in `handle()` and Laravel will inject it.

## 5. Tests

- Add the new group's defaults to `ensureSettingsExist()` in `tests/Support/SdCoreTestCase.php` (the persistent test DB may not re-run settings migrations, so this guards against `MissingSettings`).
- In tests, set values with `app(MySettings::class)->fill([...])->save();`.
- For the Filament page, add access-control coverage to `tests/Feature/Filament/SettingsPagesTest.php` (super-admin can access, regular user is forbidden).

## Checklist

- [ ] Property added to the settings class in `app/Settings`.
- [ ] Migration in `database/settings` adds the property (additive, immutable).
- [ ] `php artisan migrate` run locally.
- [ ] Filament form field added to the group's `SettingsPage` (BackOffice panel, collapsible section).
- [ ] Defaults added to `SdCoreTestCase::ensureSettingsExist()`.
- [ ] Tests cover the behaviour and page access.
- [ ] `vendor/bin/duster fix --dirty` run.
