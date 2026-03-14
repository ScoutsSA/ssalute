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
                Section::make('Role Details')
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
                                    ->label('Created By'),
                                TextEntry::make('modified')
                                    ->label('Modified At')
                                    ->dateTime()
                                    ->placeholder('-'),
                                TextEntry::make('modifiedBy.name')
                                    ->label('Modified By'),
                            ]),

                    ]),
                Section::make('Role Permissions')
                    ->columns(['sm' => 2, 'md' => 4, 'lg' => 5])
                    ->collapsed()
                    ->persistCollapsed()
                    ->id('role_meta_info')
                    ->schema([
                        IconEntry::make('sysAdmin')
                            ->boolean(),
                        IconEntry::make('nationalRole')
                            ->boolean(),
                        IconEntry::make('regionalRole')
                            ->boolean(),
                        IconEntry::make('superDistrictRole')
                            ->boolean(),
                        IconEntry::make('districtRole')
                            ->boolean(),
                        IconEntry::make('groupRole')
                            ->boolean(),
                        IconEntry::make('denRole')
                            ->boolean(),
                        IconEntry::make('packRole')
                            ->boolean(),
                        IconEntry::make('troopRole')
                            ->boolean(),
                        IconEntry::make('crewRole')
                            ->boolean(),
                        IconEntry::make('adultLeaderRole')
                            ->boolean(),
                        IconEntry::make('parentHelperRole')
                            ->boolean(),
                        IconEntry::make('alumniRole')
                            ->boolean(),
                        IconEntry::make('warrantedRole')
                            ->boolean(),
                        IconEntry::make('appointmentRole')
                            ->boolean(),
                        IconEntry::make('requiresCriminalClearance')
                            ->boolean(),
                        TextEntry::make('signsLeft')
                            ->numeric()
                            ->placeholder('-'),
                        TextEntry::make('signsRight')
                            ->numeric()
                            ->placeholder('-'),
                        IconEntry::make('chargeRole')
                            ->boolean(),
                        TextEntry::make('position')
                            ->numeric(),
                        IconEntry::make('canAdminAlumni')
                            ->boolean(),
                        IconEntry::make('canSeeAlumni')
                            ->boolean(),
                        IconEntry::make('canAdminNational')
                            ->boolean(),
                        IconEntry::make('canSeeNational')
                            ->boolean(),
                        IconEntry::make('canAdminRegion')
                            ->boolean(),
                        IconEntry::make('canSeeRegion')
                            ->boolean(),
                        IconEntry::make('canAdminRegionKids')
                            ->boolean(),
                        IconEntry::make('canAdminRegionTraining')
                            ->boolean(),
                        IconEntry::make('canAdminSuperDistrict')
                            ->boolean(),
                        IconEntry::make('canSeeSuperDistrict')
                            ->boolean(),
                        IconEntry::make('canAdminDistrict')
                            ->boolean(),
                        IconEntry::make('canSeeDistrict')
                            ->boolean(),
                        IconEntry::make('canAdminDistrictKids')
                            ->boolean(),
                        IconEntry::make('canAdminGroup')
                            ->boolean(),
                        IconEntry::make('canSeeGroup')
                            ->boolean(),
                        IconEntry::make('canAdminGroupAdults')
                            ->boolean(),
                        IconEntry::make('canAwardGroupMeerkats')
                            ->boolean(),
                        IconEntry::make('canAwardGroupCubs')
                            ->boolean(),
                        IconEntry::make('canAwardGroupScouts')
                            ->boolean(),
                        IconEntry::make('canAwardGroupRovers')
                            ->boolean(),
                        IconEntry::make('canSeeSupport')
                            ->boolean(),
                        IconEntry::make('canAdminSupport')
                            ->boolean(),
                        IconEntry::make('canAddWarrants')
                            ->boolean(),
                        IconEntry::make('canAdminProperty')
                            ->boolean(),
                        IconEntry::make('canSignWarrants')
                            ->boolean(),
                        IconEntry::make('canAdminForm29')
                            ->boolean(),
                        IconEntry::make('canAdminPoliceClearance')
                            ->boolean(),
                    ]),
            ]);
    }
}
