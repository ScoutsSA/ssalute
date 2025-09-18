<?php

namespace App\Filament\Admin\Resources\SystemUserTypes;

use App\Filament\Admin\Resources\SystemUserTypes\Pages\CreateSystemUserType;
use App\Filament\Admin\Resources\SystemUserTypes\Pages\ListSystemUserTypes;
use App\Filament\Admin\Resources\SystemUserTypes\Schemas\SystemUserTypeForm;
use App\Filament\Admin\Resources\SystemUserTypes\Schemas\SystemUserTypeInfolist;
use App\Filament\Admin\Resources\SystemUserTypes\Tables\SystemUserTypesTable;
use App\Models\SystemUserType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SystemUserTypeResource extends Resource
{
    protected static ?string $model = SystemUserType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $pluralLabel = 'Roles';

    public static function form(Schema $schema): Schema
    {
        return SystemUserTypeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SystemUserTypeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SystemUserTypesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSystemUserTypes::route('/'),
            'create' => CreateSystemUserType::route('/create'),
        ];
    }
}
