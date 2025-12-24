<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Models\Profil;
use App\Utils\Utils;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('')
            ->login()
            ->colors(Utils::getModuleColor())
            ->spa()
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
                fn() => \Livewire\Livewire::mount('mode-switcher')
            )
            ->userMenuItems([
                'logout' => fn(Action $action) => $action->label('Se Déconnecter'),
                'account' => fn(Action $action) => $action->label('Mon Compte'),
                Action::make('settings')
                    ->label('Paramètres de l\'Entreprise')
                    ->successNotificationTitle('Paramètres mis à jour avec succès')
                    ->fillForm(function (): array {
                        $profil = Profil::first();
                        return [
                            'name' => $profil?->name,
                            'phone1' => $profil?->phone1,
                            'phone2' => $profil?->phone2,
                            'niu' => $profil?->niu,
                            'service' => $profil?->service,
                            'head_office' => $profil?->head_office,
                            'trade_register' => $profil?->trade_register,
                        ];
                    })
                    ->schema([
                        TextInput::make('name')->label('Nom de l\'Entreprise')->required(),
                        TextInput::make('phone1')->label('Téléphone 1')->required(),
                        TextInput::make('phone2')->label('Téléphone 2')->nullable(),
                        TextInput::make('niu')->label('NIU')->required(),
                        TextInput::make('service')->label('Service')->required(),
                        TextInput::make('head_office')->label('Siège Social')->required(),
                        TextInput::make('trade_register')->label('Registre de Commerce')->required(),
                    ])
                    ->action(function (array $data): void {
                        $profil = Profil::first();
                        $profil->update($data);
                    })
                    ->modalHeading('Paramètres de l\'Entreprise')
                    ->modalSubmitActionLabel('Mettre a jour')
                    ->modalCancelActionLabel('Annuler')
                    ->icon('heroicon-o-cog-6-tooth'),
            ])
            ->globalSearch(false)
            ->brandName('Dech Print')
            ->brandLogo(asset('logo.svg'))
            ->brandLogoHeight('2.2rem')
            ->favicon(asset('favicon.svg'))
            ->profile(isSimple: false)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
