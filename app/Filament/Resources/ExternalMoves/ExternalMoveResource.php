<?php

namespace App\Filament\Resources\ExternalMoves;

use App\Filament\Resources\ExternalMoves\Pages\CreateExternalMove;
use App\Filament\Resources\ExternalMoves\Pages\EditExternalMove;
use App\Filament\Resources\ExternalMoves\Pages\ListExternalMoves;
use App\Filament\Resources\ExternalMoves\Schemas\ExternalMoveForm;
use App\Filament\Resources\ExternalMoves\Tables\ExternalMovesTable;
use App\Models\ExternalMove;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ExternalMoveResource extends Resource
{
    protected static ?string $model = ExternalMove::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Mouvements externes';

    public static function form(Schema $schema): Schema
    {
        return ExternalMoveForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExternalMovesTable::configure($table);
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
            'index' => ListExternalMoves::route('/'),
        ];
    }
}
