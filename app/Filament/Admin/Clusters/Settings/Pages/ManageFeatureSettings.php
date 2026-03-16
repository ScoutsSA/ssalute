<?php

namespace App\Filament\Admin\Clusters\Settings\Pages;

use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Settings\FeatureSettings;
use BackedEnum;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageFeatureSettings extends SettingsPage
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::Flag;

    protected static string $settings = FeatureSettings::class;

    protected static ?string $navigationLabel = 'Feature Flags';

    protected static ?string $cluster = SettingsCluster::class;

    protected static ?int $navigationSort = 1;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('General Panel Features')
                    ->description('Toggle features on or off for users in the general panel. All features are off by default.')
                    ->schema([
                        Toggle::make('users_can_edit_profiles')
                            ->label('Users can edit profiles')
                            ->helperText('Allow users to edit their own profile information.')
                            ->inline(false)
                            ->columnSpanFull(),
                        Toggle::make('users_can_browse_areas')
                            ->label('Users can browse areas')
                            ->helperText('Allow users to browse Regions, Districts, and Groups.')
                            ->inline(false)
                            ->columnSpanFull(),
                        Toggle::make('users_can_upload_profile_photo')
                            ->label('Users can upload profile photo')
                            ->helperText('Allow users to upload or change their profile photo.')
                            ->inline(false)
                            ->columnSpanFull(),
                        Toggle::make('users_can_add_documents')
                            ->label('Users can add documents')
                            ->helperText('Allow users to add documents to their profile.')
                            ->inline(false)
                            ->columnSpanFull(),
                        Toggle::make('users_can_add_past_service')
                            ->label('Users can add past service')
                            ->helperText('Allow users to add past service records.')
                            ->inline(false)
                            ->columnSpanFull(),
                        Toggle::make('users_can_add_past_training')
                            ->label('Users can add past training')
                            ->helperText('Allow users to add past training records.')
                            ->inline(false)
                            ->columnSpanFull(),
                        Toggle::make('users_can_add_awards')
                            ->label('Users can add awards')
                            ->helperText('Allow users to add award records.')
                            ->inline(false)
                            ->columnSpanFull(),
                        Toggle::make('users_can_view_notifications')
                            ->label('Users can view notifications')
                            ->helperText('Show legacy notifications on the dashboard and notifications page.')
                            ->inline(false)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
