<?php

namespace App\Filament\Admin\Clusters\LookupTables\Resources\SupportChatStandardAnswers;

use App\Filament\Admin\Clusters\LookupTables\LookupTablesCluster;
use App\Filament\Admin\Clusters\LookupTables\Resources\SupportChatStandardAnswers\Pages\ManageSupportChatStandardAnswers;
use App\Models\SupportChatsStandardAnswer;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SupportChatStandardAnswerResource extends Resource
{
    protected static ?string $model = SupportChatsStandardAnswer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChatBubbleLeftRight;

    protected static ?string $pluralLabel = 'Support Chat Standard Answers';

    protected static ?string $cluster = LookupTablesCluster::class;

    protected static ?int $navigationSort = 136;

    protected static string|UnitEnum|null $navigationGroup = 'Content & Support';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Textarea::make('answer')->label('Answer')->required()->columnSpanFull(),
            Toggle::make('autoClose')->label('Auto Close')->inline(false)->helperText('Automatically closes the chat after this answer is sent.'),
            Toggle::make('active')->label('Active')->default(true)->inline(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordAction(EditAction::class)
            ->defaultPaginationPageOption(25)
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->description('Database table: ' . app(static::getModel())->getTable() . '. Legacy usage: canned replies available to support staff inside the support chat.')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('answer')->label('Answer')->searchable()->limit(80)->toggleable(),
                IconColumn::make('autoClose')->label('Auto Close')->boolean()->toggleable(),
                IconColumn::make('active')->label('Active')->boolean()->toggleable(),
            ])
            ->defaultSort('id');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSupportChatStandardAnswers::route('/'),
        ];
    }
}
