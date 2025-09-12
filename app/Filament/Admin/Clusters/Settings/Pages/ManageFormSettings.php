<?php

namespace App\Filament\Admin\Clusters\Settings\Pages;

use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Settings\FormSettings;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageFormSettings extends SettingsPage
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::DocumentText;

    protected static string $settings = FormSettings::class;

    protected static ?string $cluster = SettingsCluster::class;
    protected static ?string $navigationLabel = 'Form Settings';
    protected static ?int $navigationSort = 1;

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
                            Tabs\Tab::make('AAM Form')
                                ->schema([
                                    Toggle::make('aam_enabled')
                                        ->label('AAM Process Enabled')
                                        ->columnSpanFull(),
                                    TextInput::make('aam_national_support_emails')
                                        ->label('National Support Emails')
                                        ->helperText('A comma-separated list of national email addresses to receive support requests from the AAM form.')
                                        ->columnSpanFull()
                                        ->nullable(),
                                ]),

                        ]),
            ]);
    }
}
