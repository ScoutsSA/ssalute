<?php

namespace App\Filament\Admin\Clusters\Area\Schemas;

use App\Models\GroupAccount;
use App\Models\SystemCountryName;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;

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
            ->options(fn (mixed $state): array => self::keepingCurrent(SystemCountryName::query()
                ->orderBy('country_name')
                ->get()
                ->mapWithKeys(fn (SystemCountryName $country): array => [
                    $country->country_id => "{$country->country_name} (#{$country->country_id})",
                ])
                ->all(), $state, 'Unknown country'))
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
            ->options(fn (mixed $state): array => self::keepingCurrent(GroupAccount::query()
                ->orderBy('accountName')
                ->get()
                ->mapWithKeys(fn (GroupAccount $account): array => [
                    $account->id => "{$account->accountName} (#{$account->id})",
                ])
                ->all(), $state, 'Unknown account'))
            ->searchable()
            ->preload()
            ->nullable()
            ->formatStateUsing(fn (mixed $state): ?int => $state ? (int) $state : null)
            ->dehydrateStateUsing(fn (mixed $state): int => (int) ($state ?? 0));
    }

    /**
     * Keep the field's current value selectable even when it is missing from the options.
     *
     * The legacy schema has no foreign keys, so a record can point at a row that was deleted or that sits
     * outside the list the select is scoped to. Filament validates a select against its options, so without
     * this an admin editing an unrelated field is refused until they re-pick the value. The stray value is
     * listed first, labelled so the drift is visible, and nothing is changed unless the admin changes it.
     *
     * @param  array<int|string, string>  $options
     * @param  string|Closure(int): string  $label  A prefix for "Prefix (#id)", or a closure building the whole label.
     * @return array<int|string, string>
     */
    public static function keepingCurrent(array $options, mixed $state, string|Closure $label): array
    {
        if (blank($state) || (int) $state === 0 || array_key_exists((int) $state, $options)) {
            return $options;
        }

        $id = (int) $state;

        return [$id => $label instanceof Closure ? $label($id) : "{$label} (#{$id})"] + $options;
    }

    /**
     * Label for a stored district or super district that sits outside the region the select is scoped to.
     */
    public static function strayAreaLabel(?Model $area, string $type, int $id): string
    {
        if ($area === null) {
            return "Unknown {$type} (#{$id})";
        }

        $region = $area->region;
        $regionLabel = $region ? "{$region->name} (#{$region->id})" : "region #{$area->regionID}";

        return "{$area->name} (#{$id}, in {$regionLabel}, not this region)";
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
