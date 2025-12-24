<?php

namespace App\Livewire;

use App\Models\PointOfSale;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class PointOfSaleUsers extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;

    public PointOfSale $pointOfSale;
    public ?array $data = [];

    public function mount(int $pointOfSaleId): void
    {
        $this->pointOfSale = PointOfSale::findOrFail($pointOfSaleId);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->pointOfSale->users()
                ->select("users.*")
                ->getQuery())
            ->columns([
                TextColumn::make('name')
                    ->label("Nom")
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->copyMessageDuration(1500),
            ])
            ->recordActions([
                Action::make('remove')
                    ->label('Supprimer')
                    ->icon('heroicon-o-trash')
                    ->iconButton()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading("Retirer l'agent")
                    ->modalDescription(fn ($record) => "Voulez vous retirer l'agent {$record->name} du point de vente ?")
                    ->modalSubmitActionLabel('Oui, supprimer')
                    ->action(function ($record) {
                        $this->pointOfSale->users()->detach($record->id);
                        Notification::make()
                            ->title('Agent retirer avec success')
                            ->body("{$record->name} a été retirer du point de vente {$this->pointOfSale->name}.")
                            ->success()
                            ->send();

                        $this->refreshComponent();
                    }),
            ])->paginated([5, 10])
            ->defaultPaginationPageOption(5)
            ->emptyStateHeading('Aucun agent')
            ->emptyStateDescription('Aucun agent assigné a ce point de vente')
            ->emptyStateIcon('heroicon-o-users');
    }

    public function refreshComponent(): void
    {
        $this->pointOfSale->refresh();
        $this->dispatch('$refresh');
    }
    public function render()
    {
        return view('livewire.point-of-sale-users');
    }
}
