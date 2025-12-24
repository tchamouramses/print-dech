<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\Enums\UserRoleEnum;
use App\Models\PointOfSale;
use App\Models\User;
use App\Utils\Utils;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Adresse Email')
                    ->searchable(),
                TextColumn::make('role')
                    ->label('Rôle')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Date de création')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('assign')
                    ->icon('heroicon-o-user')
                    ->visible(fn($record) => Utils::isTransaction() && $record->role === UserRoleEnum::POINT_OF_SALES)
                    ->disabled(fn($record) => PointOfSale::whereDoesntHave('users', fn($query) => $query->where('users.id', $record->id))->count() === 0)
                    ->iconButton()
                    ->color('secondary')
                    ->tooltip('Ajouter un agent')
                    ->schema(function ($record) {
                        return [
                            Select::make('point_of_sale_id')
                                ->label('Agent')
                                ->options(PointOfSale::whereDoesntHave('users', fn($query) => $query->where('users.id', $record->id))->pluck('name', 'id')->toArray())
                                ->required()
                        ];
                    })
                    ->modalHeading('Ajouter un agent')
                    ->modalWidth(Width::Small)
                    ->modalSubmitActionLabel('Ajouter')
                    ->modalCancelActionLabel('Annuler')
                    ->action(function (array $data, User $record): void {
                        $record->pointOfSales()->attach($data['point_of_sale_id']);
                        Notification::make()
                            ->title('Enregistré')
                            ->success()
                            ->body('Agent ajouté au point de vente')
                            ->send();

                    }),

                EditAction::make()->iconButton()
                    ->tooltip('Modifier')
                    ->disabled(fn ($record) => $record->id === auth()->id()),
                DeleteAction::make()->iconButton()
                    ->tooltip('Supprimer')
                    ->disabled(fn ($record) => $record->id === auth()->id()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
