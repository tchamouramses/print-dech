<?php

namespace App\Filament\Resources\MoveTypes;

use App\Filament\Resources\MoveTypes\Pages\CreateMoveType;
use App\Filament\Resources\MoveTypes\Pages\EditMoveType;
use App\Filament\Resources\MoveTypes\Pages\ListMoveTypes;
use App\Filament\Resources\MoveTypes\Schemas\MoveTypeForm;
use App\Filament\Resources\MoveTypes\Tables\MoveTypesTable;
use App\Models\MoveType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MoveTypeResource extends Resource
{
    protected static ?string $model = MoveType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Type de mouvement';

    public static function form(Schema $schema): Schema
    {
        return MoveTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MoveTypesTable::configure($table);
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
            'index' => ListMoveTypes::route('/'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Type de mouvements';
    }

    public static function getRecordTitleAttribute(): ?string
    {
        return 'Type de mouvement';
    }
}
