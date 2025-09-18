<?php

namespace App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests;

use App\Filament\Admin\Clusters\Forms\FormsCluster;
use App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\Pages\EditApplicationAdultMembershipRequest;
use App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\Pages\ListApplicationAdultMembershipRequests;
use App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\Schemas\ApplicationAdultMembershipRequestForm;
use App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\Schemas\ApplicationAdultMembershipRequestInfolist;
use App\Filament\Admin\Clusters\Forms\Resources\ApplicationAdultMembershipRequests\Tables\ApplicationAdultMembershipRequestsTable;
use App\Models\Forms\ApplicationAdultMembershipRequest;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ApplicationAdultMembershipRequestResource extends Resource
{
    protected static ?string $model = ApplicationAdultMembershipRequest::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Identification;
    protected static ?string $label = 'AAM Requests';

    protected static ?string $cluster = FormsCluster::class;

    public static function form(Schema $schema): Schema
    {
        return ApplicationAdultMembershipRequestForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ApplicationAdultMembershipRequestInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApplicationAdultMembershipRequestsTable::configure($table);
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
            'index' => ListApplicationAdultMembershipRequests::route('/'),
            'edit' => EditApplicationAdultMembershipRequest::route('/{record}/edit'),
        ];
    }
}
