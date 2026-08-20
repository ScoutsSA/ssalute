<?php

namespace App\Filament\Admin\Clusters\DataFixes\Pages;

use App\Services\SystemFixes\FlagUsersWithoutRoleInHomeLocation;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;

class HomeLocationRoles extends FindingsPage
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::MapPin;

    protected static ?string $navigationLabel = 'Home Location Roles';

    protected static ?string $title = 'Members with no role in their home location';

    protected static ?int $navigationSort = 2;

    public static function fix(): string
    {
        return FlagUsersWithoutRoleInHomeLocation::class;
    }

    protected static function subject(): string
    {
        return 'members';
    }

    /**
     * Most of these are one member holding one role at one place that is not their home, which is
     * a single-click correction. Making the admin open the member, find the association fields and
     * work out which of group/district/region to change turns a click into a chore, so the choice
     * is offered here with the member's own role locations as the options.
     */
    protected function solveAction(): ?Action
    {
        return Action::make('setHome')
            ->label('Set home location')
            ->icon(Heroicon::MapPin)
            ->modalHeading(fn (array $record): string => "Set home location for {$record['title']}")
            ->modalSubmitActionLabel('Save home location')
            ->modalWidth('lg')
            ->schema(fn (array $record): array => [
                Placeholder::make('current')
                    ->label('Current home')
                    ->content($record['group'] ?? 'unknown'),
                Placeholder::make('problem')
                    ->label('Why this is flagged')
                    ->content($record['detail']),
                Radio::make('candidate')
                    ->label('Move home to')
                    ->options($this->candidates((int) $record['recordId']))
                    ->required()
                    ->helperText('Taken from where this member\'s active roles actually sit. Their roles are not changed.'),
            ])
            ->action(function (array $record, array $data): void {
                app(static::fix())->setHome((int) $record['recordId'], $data['candidate']);

                Notification::make()
                    ->success()
                    ->title('Home location updated')
                    ->body("{$record['title']} now matches where their role sits.")
                    ->send();
            })
            // A member whose roles resolve to no usable location cannot be fixed this way;
            // the row still links out to the record.
            ->visible(fn (array $record): bool => filled($record['recordId'])
                && $this->candidates((int) $record['recordId']) !== []);
    }

    /**
     * @return array<string, string>
     */
    private function candidates(int $userId): array
    {
        return app(static::fix())->homeCandidates($userId);
    }
}
