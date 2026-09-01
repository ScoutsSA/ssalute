<?php

namespace App\Filament\Admin\Clusters\BranchManagement\Resources\Badges;

use App\Filament\Admin\Clusters\BranchManagement\BranchManagementCluster;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\RelationManagers\BadgeTasksRelationManager;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Schemas\BadgeForm;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Schemas\BadgeInfolist;
use App\Filament\Admin\Clusters\BranchManagement\Resources\Badges\Tables\BadgesTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

abstract class BaseBadgeResource extends Resource
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::CheckBadge;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Badges';

    protected static ?string $cluster = BranchManagementCluster::class;

    public static function form(Schema $schema): Schema
    {
        return BadgeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BadgeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BadgesTable::configure($table, static::getModel());
    }

    public static function getRelations(): array
    {
        return [
            BadgeTasksRelationManager::make(),
        ];
    }
}
