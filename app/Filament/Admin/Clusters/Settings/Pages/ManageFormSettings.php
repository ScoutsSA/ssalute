<?php

namespace App\Filament\Admin\Clusters\Settings\Pages;

use App\Filament\Admin\Clusters\Settings\SettingsCluster;
use App\Models\SystemUserType;
use App\Settings\FormSettings;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageFormSettings extends SettingsPage
{
    protected static string|null|BackedEnum $navigationIcon = Heroicon::DocumentText;

    protected static string $settings = FormSettings::class;

    protected static ?string $navigationLabel = 'Form Settings';

    protected static ?string $cluster = SettingsCluster::class;
    protected static ?int $navigationSort = 1;

    public function form(Schema $schema): Schema
    {
        $roles = SystemUserType::active()->orderBy('position')->pluck('name', 'id')->toArray();

        return $schema
            ->schema([
                Tabs::make()
                    ->columns(1)
                    ->persistTabInQueryString()
                    ->columnSpanFull()
                    ->schema(
                        [
                            Tab::make('AAM Form')
                                ->schema([
                                    Tabs::make()
                                        ->schema([
                                            Tab::make('General')
                                                ->schema([
                                                    Toggle::make('aam_enabled')
                                                        ->label('AAM Process Enabled')
                                                        ->columnSpanFull(),
                                                ]),
                                            Tab::make('Email Log')
                                                ->schema([
                                                    TextEntry::make('next_in_line_info')
                                                        ->state('This is for system logging purposes. If you have some email addresses that you\'d like to always be bcc\'d on the AAM emails you can add them here. These will be added in addition to the National Support Emails below.')
                                                        ->columnSpanFull(),
                                                    TextInput::make('aam_national_support_emails')
                                                        ->label('National Support Email BCC Log')
                                                        ->helperText('This supports multiple emails, just separate them with a comma.')
                                                        ->trim()
                                                        ->columnSpanFull(),
                                                ]),

                                            Tab::make('Approval')
                                                ->schema([
                                                    TextEntry::make('approval_info')
                                                        ->hiddenLabel()
                                                        ->state('These options are the "CC" for the emails we send. They will ALSO be able to action the AAM requests, but they\'re not the primary contact.')
                                                        ->columnSpanFull(),
                                                    TextEntry::make('approval_note')
                                                        ->hiddenLabel()
                                                        ->state('ONLY active users with one of these active roles (scoped for area) will be able to action the AAM requests. You can select multiple roles for each level, if you do then all users with any of those roles will be able to action the request.')
                                                        ->columnSpanFull(),
                                                    Select::make('aam_approval_role_national')
                                                        ->label('National Role')
                                                        ->options($roles)
                                                        ->multiple()
                                                        ->helperText("We'd recommend your National Chair & Team for Adult Support")
                                                        ->searchable()
                                                        ->columnSpanFull(),
                                                    Select::make('aam_approval_role_regional')
                                                        ->label('Regional Role')
                                                        ->options($roles)
                                                        ->multiple()
                                                        ->helperText("We'd recommend your Adult Support & Team")
                                                        ->searchable()
                                                        ->columnSpanFull(),
                                                    Select::make('aam_approval_role_district')
                                                        ->label('District Role')
                                                        ->options($roles)
                                                        ->multiple()
                                                        ->helperText("We'd recommend your District Commissioner, District Manager & District Group Manager")
                                                        ->searchable()
                                                        ->columnSpanFull(),
                                                    Select::make('aam_approval_role_group')
                                                        ->label('Group Role')
                                                        ->options($roles)
                                                        ->multiple()
                                                        ->helperText("We'd recommend your Scout Group Leader, perhaps also your Section Leaders (Den/Pack/Troop/Crew Scouters)")
                                                        ->searchable()
                                                        ->columnSpanFull(),
                                                ]),
                                        ]),
                                ]),
                        ]),

            ]);
    }
}
