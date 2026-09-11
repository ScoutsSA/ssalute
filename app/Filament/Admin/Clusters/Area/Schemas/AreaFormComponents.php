<?php

namespace App\Filament\Admin\Clusters\Area\Schemas;

use App\Models\GroupAccount;
use App\Models\SystemCountryName;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;

/**
 * Form pieces shared by the region, district and group forms.
 */
class AreaFormComponents
{
    public const DEFAULT_COUNTRY_ID = 196;

    public static function countrySelect(string $name, string $label = 'Country', bool $required = true): Select
    {
        $select = Select::make($name)
            ->label($label)
            ->options(fn (): array => SystemCountryName::query()
                ->orderBy('country_name')
                ->get()
                ->mapWithKeys(fn (SystemCountryName $country): array => [
                    $country->country_id => "{$country->country_name} (#{$country->country_id})",
                ])
                ->all())
            ->searchable()
            ->preload()
            ->default(self::DEFAULT_COUNTRY_ID);

        if ($required) {
            return $select->required();
        }

        return $select->nullable();
    }

    /**
     * Select for a legacy int NOT NULL DEFAULT 0 account column: empty in the form, 0 in the database.
     */
    public static function accountSelect(string $name, string $label = 'Account'): Select
    {
        return Select::make($name)
            ->label($label)
            ->options(fn (): array => GroupAccount::query()
                ->orderBy('accountName')
                ->get()
                ->mapWithKeys(fn (GroupAccount $account): array => [
                    $account->id => "{$account->accountName} (#{$account->id})",
                ])
                ->all())
            ->searchable()
            ->preload()
            ->nullable()
            ->formatStateUsing(fn (mixed $state): ?int => $state ? (int) $state : null)
            ->dehydrateStateUsing(fn (mixed $state): int => (int) ($state ?? 0));
    }

    /**
     * Read only audit columns, shown on the edit page only.
     *
     * @param  list<string>  $extraEntries
     */
    public static function auditSection(bool $hasTimestamps = true, array $extraEntries = []): Section
    {
        $entries = [
            TextEntry::make('id')->label('ID'),
        ];

        if ($hasTimestamps) {
            $entries[] = TextEntry::make('created')->label('Created At')->dateTime()->placeholder('-');
            $entries[] = TextEntry::make('createdBy.name')->label('Created By')->placeholder('-');
            $entries[] = TextEntry::make('modified')->label('Modified At')->dateTime()->placeholder('-');
            $entries[] = TextEntry::make('modifiedBy.name')->label('Modified By')->placeholder('-');
        }

        foreach ($extraEntries as $entry) {
            $entries[] = $entry;
        }

        return Section::make('Audit')
            ->description('Read only. Stamped by the system.')
            ->columns(3)
            ->collapsible()
            ->collapsed()
            ->hiddenOn('create')
            ->schema($entries);
    }
}
