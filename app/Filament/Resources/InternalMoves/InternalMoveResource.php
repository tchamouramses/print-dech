<?php

namespace App\Filament\Resources\InternalMoves;

use App\Filament\Resources\InternalMoves\Pages\CreateInternalMove;
use App\Filament\Resources\InternalMoves\Pages\EditInternalMove;
use App\Filament\Resources\InternalMoves\Pages\ListInternalMoves;
use App\Filament\Resources\InternalMoves\Schemas\InternalMoveForm;
use App\Filament\Resources\InternalMoves\Tables\InternalMovesTable;
use App\Models\InternalMove;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InternalMoveResource extends Resource
{
    protected static ?string $model = InternalMove::class;

    protected static string|BackedEnum|null $navigationIcon = 'iconsax-two-money-recive';

    public static function form(Schema $schema): Schema
    {
        return InternalMoveForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InternalMovesTable::configure($table);
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
            'index' => ListInternalMoves::route('/'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Mouvements internes';
    }

    public static function getRecordTitleAttribute(): ?string
    {
        return 'Mouvements Internes';
    }
}
