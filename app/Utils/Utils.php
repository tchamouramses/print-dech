<?php
 namespace App\Utils;

 use App\Models\Bilan;
 use App\Models\Enums\ModuleTypeEnum;
 use App\Models\PointOfSale;
 use Carbon\Carbon;
 use Filament\Support\Colors\Color;
 use Illuminate\Support\Collection;
 use Illuminate\Support\Facades\Cache;

 class Utils
 {
     public const string MODULE_TYPE_CACHE_KEY = 'MODULE_TYPE_CACHE_KEY';
     public static function getType()
     {
         $userId = auth()->check() ? auth()->id() : '';
         return Cache::get(self::MODULE_TYPE_CACHE_KEY . $userId, function () {
             return ModuleTypeEnum::TRANSACTION->value;
         });
     }

     public static function isPrint(): bool
     {
         return self::getType() === ModuleTypeEnum::PRINT->value;
     }

     public static function isTransaction(): bool
     {
         return self::getType() === ModuleTypeEnum::TRANSACTION->value;
     }

     public static function isStock(): bool
     {
         return self::getType() === ModuleTypeEnum::STOCK->value;
     }

     public static function setType(ModuleTypeEnum $type): void
     {
         $userId = auth()->id();
         Cache::forever(self::MODULE_TYPE_CACHE_KEY . $userId, $type->value);
     }

     public static function formatAmount(float $amount): string
     {
         return number_format($amount, 0, '.', ' ');
     }

     public static function getModuleColor(): array
     {
         return match (self::getType()) {
             ModuleTypeEnum::TRANSACTION->value => [
                 'primary' => Color::Amber,
                 'secondary' => Color::Green,
             ],
             ModuleTypeEnum::STOCK->value => [
                 'primary' => Color::Fuchsia,
                 'secondary' => Color::Green,
             ],
             ModuleTypeEnum::PRINT->value => [
                 'primary' => Color::Stone,
                 'secondary' => Color::Amber,
             ],
         };
     }

     public static function getCurrentBilan($date, $point_of_sale_id): Bilan
     {
         $day = Carbon::parse($date);
         return Bilan::whereBetween('date', [$day->startOfDay(), $day->endOfDay()])
             ->where('point_of_sale_id', $point_of_sale_id)
             ->firstOrCreate(
                 [
                     'date' => Carbon::parse($day)->format('Y-m-d'),
                     'point_of_sale_id' => $point_of_sale_id
                 ]
             );
     }

     public static function pointOfSales(): Collection
     {
         return auth()->user()->isAdmin()
             ? PointOfSale::all()
             : auth()->user()->pointOfSales()->get();
     }
 }
