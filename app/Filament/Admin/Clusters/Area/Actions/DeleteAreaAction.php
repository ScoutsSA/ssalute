<?php

namespace App\Filament\Admin\Clusters\Area\Actions;

use App\Services\Areas\AreaDeletionGuard;
use App\Services\Areas\AreaReferenceMap;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

/**
 * Delete action for regions, districts and groups.
 *
 * When nothing references the record it is a plain confirmation. When other tables do, the modal lists every
 * table with its row count, states exactly what a forced delete does to those rows (nothing: they are neither
 * deleted nor nullified and keep pointing at the missing id), and requires an acknowledgement plus the record
 * name typed back before the delete goes through.
 */
class DeleteAreaAction extends DeleteAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->modalHeading(fn (Model $record): string => "Delete {$record->getAttribute('name')} (#{$record->getKey()})");

        $this->modalDescription(function (Model $record): string {
            $blockers = $this->blockersFor($record);
            $type = strtolower(class_basename($record));

            if ($blockers === []) {
                return "No other records reference this {$type}. It will be permanently deleted.";
            }

            $rows = array_sum($blockers);
            $tables = count($blockers);

            return "Warning: {$rows} rows in {$tables} tables reference this {$type}. Read what a forced delete does before continuing.";
        });

        $this->modalSubmitActionLabel(fn (Model $record): string => $this->blockersFor($record) === [] ? 'Delete' : 'Force delete');

        $this->schema(fn (Model $record): array => $this->blockersFor($record) === [] ? [] : [
            Section::make('Records that reference this record')
                ->description('Each table below is also a tab on the record, where the rows can be inspected and moved or deleted first.')
                ->schema([
                    TextEntry::make('blockers')
                        ->hiddenLabel()
                        ->badge()
                        ->color('warning')
                        ->state(fn (): array => $this->describeBlockers($record)),
                ]),
            Section::make('What a forced delete does')
                ->schema([
                    TextEntry::make('consequences')
                        ->hiddenLabel()
                        ->state(fn (): HtmlString => $this->consequences($record)),
                ]),
            Checkbox::make('acknowledged')
                ->label('I understand that the related records will be left pointing at a record that no longer exists.')
                ->accepted()
                ->validationMessages(['accepted' => 'You must acknowledge the consequences to force the delete.']),
            TextInput::make('confirmation')
                ->label(fn (): string => "Type {$record->getAttribute('name')} to confirm")
                ->required()
                ->in(fn (): array => [$record->getAttribute('name')])
                ->validationMessages(['in' => 'The name does not match the record.']),
        ]);

        $this->using(function (Model $record): ?bool {
            $blockers = $this->blockersFor($record);

            if ($blockers === []) {
                return $record->delete();
            }

            $result = $record->forceDeleteWhileReferenced();

            if ($result) {
                Notification::make()
                    ->title("Forced delete of {$record->getAttribute('name')} (#{$record->getKey()})")
                    ->body(array_sum($blockers) . ' related rows in ' . count($blockers) . " tables were left unchanged and now reference a record that no longer exists: {$this->summary($blockers)}.")
                    ->warning()
                    ->persistent()
                    ->send();
            }

            return $result;
        });
    }

    /**
     * @return array<string, int>
     */
    protected function blockersFor(Model $record): array
    {
        $guard = resolve(AreaDeletionGuard::class);
        $guard->forget($record);

        return $guard->blockersFor($record);
    }

    /**
     * @return list<string>
     */
    protected function describeBlockers(Model $record): array
    {
        $lines = [];

        foreach ($this->blockersFor($record) as $table => $count) {
            $rows = $count === 1 ? 'row' : 'rows';
            $lines[] = AreaReferenceMap::label($table) . ": {$count} {$rows}";
        }

        return $lines;
    }

    /**
     * @param  array<string, int>  $blockers
     */
    protected function summary(array $blockers): string
    {
        return AreaDeletionGuard::describe($blockers);
    }

    protected function consequences(Model $record): HtmlString
    {
        $type = strtolower(class_basename($record));
        $id = $record->getKey();
        $name = e($record->getAttribute('name'));

        return new HtmlString(<<<HTML
<ul class="list-disc space-y-1 ps-5">
    <li><strong>Only this {$type} is deleted.</strong> {$name} (#{$id}) is removed permanently. There is no undo.</li>
    <li><strong>The related rows are not deleted.</strong> Users, role attachments, sections, records and log entries listed above all stay in the database.</li>
    <li><strong>The related rows are not changed.</strong> Their {$type} column is not cleared or set to 0. They keep the value #{$id}, which will no longer match any {$type}.</li>
    <li><strong>What that looks like afterwards.</strong> Anywhere those rows are shown, this {$type} appears as missing or unknown. Area scoped queries and reports that join on the {$type} will not find them, and role attachments scoped to it no longer grant access to a real area.</li>
    <li><strong>To avoid orphaned rows</strong>, move or delete them first using the tabs on this record, then delete the {$type} normally.</li>
</ul>
HTML);
    }
}
