<?php

namespace App\Livewire;

use App\Models\Enums\ModuleTypeEnum;
use App\Utils\Utils;
use Filament\Notifications\Notification;
use Livewire\Component;

class ModeSwitcher extends Component
{
    public string $mode;

    public function updatedMode($value)
    {
        Utils::setType(ModuleTypeEnum::from($value));
        Notification::make()
                ->title('Mode changé avec succès')
                ->body("Vous etes en mode " . ModuleTypeEnum::from(Utils::getType())->getLabel())
                ->success()
                ->send();
        return redirect('/');
    }

    public function render()
    {
        $this->mode = Utils::getType();
        return view('livewire.mode-switcher');
    }
}
