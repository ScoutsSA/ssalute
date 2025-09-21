<?php

namespace App\Filament\Admin\Resources\Roles\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Group Details')
                    ->collapsible()
                    ->persistCollapsed()
                    ->columns(2)
                    ->id('role_details')
                    ->schema([
                        TextEntry::make('name')
                            ->columnSpanFull(),
                        IconEntry::make('active')
                            ->label('Active')
                            ->columnSpanFull()
                            ->boolean(),
                        TextEntry::make('description')
                            ->columnSpanFull(),
                        Fieldset::make('Changes')
                            ->columns(['sm' => 2, 'md' => 4, 'lg' => 4])
                            ->columnSpanFull()
                            ->schema([
                                TextEntry::make('created')
                                    ->label('Created At')
                                    ->dateTime(),
                                TextEntry::make('createdBy.name')
                                    ->label('Created By')
                                    ->numeric(),
                                TextEntry::make('modified')
                                    ->label('Modified At')
                                    ->dateTime()
                                    ->placeholder('-'),
                                TextEntry::make('modifiedBy.name')
                                    ->label('Modified By')
                                    ->numeric(),
                            ]),

                    ]),
                Section::make('Group Meta Info')
                    ->columns(['sm' => 2, 'md' => 4, 'lg' => 5])
                    ->collapsed()
                    ->persistCollapsed()
                    ->id('role_meta_info')
                    ->schema([

                        TextEntry::make('sysAdmin')
                            ->numeric(),
                        TextEntry::make('nationalRole')
                            ->numeric(),
                        TextEntry::make('regionalRole')
                            ->numeric(),
                        TextEntry::make('superDistrictRole')
                            ->numeric(),
                        TextEntry::make('districtRole')
                            ->numeric(),
                        TextEntry::make('groupRole')
                            ->numeric(),
                        TextEntry::make('denRole')
                            ->numeric(),
                        TextEntry::make('packRole')
                            ->numeric(),
                        TextEntry::make('troopRole')
                            ->numeric(),
                        TextEntry::make('crewRole')
                            ->numeric(),
                        TextEntry::make('adultLeaderRole')
                            ->numeric(),
                        TextEntry::make('parentHelperRole')
                            ->numeric(),
                        TextEntry::make('alumniRole')
                            ->numeric(),
                        TextEntry::make('warrantedRole')
                            ->numeric(),
                        TextEntry::make('appointmentRole')
                            ->numeric(),
                        TextEntry::make('requiresCriminalClearance')
                            ->numeric(),
                        TextEntry::make('signsLeft')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('signsRight')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('chargeRole')
                            ->numeric(),
                        TextEntry::make('position')
                            ->numeric(),
                        TextEntry::make('canAdminAlumni')
                            ->numeric(),
                        TextEntry::make('canSeeAlumni')
                            ->numeric(),
                        TextEntry::make('canAdminNational')
                            ->numeric(),
                        TextEntry::make('canSeeNational')
                            ->numeric(),
                        TextEntry::make('canAdminRegion')
                            ->numeric(),
                        TextEntry::make('canSeeRegion')
                            ->numeric(),
                        TextEntry::make('canAdminRegionKids')
                            ->numeric(),
                        TextEntry::make('canAdminRegionTraining')
                            ->numeric(),
                        TextEntry::make('canAdminSuperDistrict')
                            ->numeric(),
                        TextEntry::make('canSeeSuperDistrict')
                            ->numeric(),
                        TextEntry::make('canAdminDistrict')
                            ->numeric(),
                        TextEntry::make('canSeeDistrict')
                            ->numeric(),
                        TextEntry::make('canAdminDistrictKids')
                            ->numeric(),
                        TextEntry::make('canAdminGroup')
                            ->numeric(),
                        TextEntry::make('canSeeGroup')
                            ->numeric(),
                        TextEntry::make('canAdminGroupAdults')
                            ->numeric(),
                        TextEntry::make('canAwardGroupMeerkats')
                            ->numeric(),
                        TextEntry::make('canAwardGroupCubs')
                            ->numeric(),
                        TextEntry::make('canAwardGroupScouts')
                            ->numeric(),
                        TextEntry::make('canAwardGroupRovers')
                            ->numeric(),
                        TextEntry::make('canSeeSupport')
                            ->numeric(),
                        TextEntry::make('canAdminSupport')
                            ->numeric(),
                        TextEntry::make('canAddWarrants')
                            ->numeric(),
                        TextEntry::make('canAdminProperty')
                            ->numeric(),
                        TextEntry::make('canSignWarrants')
                            ->numeric(),
                        TextEntry::make('canAdminForm29')
                            ->numeric(),
                        TextEntry::make('canAdminPoliceClearance')
                            ->numeric(),
                    ]),
            ]);
    }
}
