<?php

namespace App\Filament\Admin\Clusters\Settings\Pages;

use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Models\SystemUser;
use App\Settings\GeneralSettings;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageGeneralSettings extends SettingsPage
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::Cog8Tooth;

    protected static string $settings = GeneralSettings::class;

    protected static ?string $navigationLabel = 'General Settings';

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 2;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make()
                    ->columns(1)
                    ->persistTabInQueryString()
                    ->columnSpanFull()
                    ->schema(
                        [
                            Tab::make('BackOffice Panel')
                                ->schema([
                                    Select::make('super_user_admin_list')
                                        ->label('Super User Admin List')
                                        ->multiple()
                                        ->searchable()
                                        ->options([])
                                        ->getSearchResultsUsing(fn (string $search): array => SystemUser::query()
                                            ->where('username', 'like', "{$search}%")
                                            ->orWhere('id', '=', $search)
                                            ->limit(50)
                                            ->get()
                                            ->mapWithKeys(fn ($user) => [
                                                $user->id => "{$user->username} [{$user->name} - {$user->id}]",
                                            ])
                                            ->toArray())
                                        ->getOptionLabelsUsing(fn (array $values): array => SystemUser::whereIn('id', $values)
                                            ->get()
                                            ->mapWithKeys(fn ($user) => [
                                                $user->id => "{$user->username} [{$user->name} - {$user->id}]",
                                            ])
                                            ->toArray()
                                        )
                                        ->helperText('List of users who should have super admin access to the BackOffice panel. Search via username or ID.')
                                        ->columnSpanFull(),
                                ]),
                        ]),
            ]);
    }
}
