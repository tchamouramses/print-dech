<?php
 namespace App\Utils;

 use App\Models\Enums\ModuleTypeEnum;
 use Filament\Support\Colors\Color;
 use Illuminate\Support\Facades\Cache;

 class Utils
 {
     public const string MODULE_TYPE_CACHE_KEY = 'MODULE_TYPE_CACHE_KEY';
     public static function getType()
     {
         return Cache::get(self::MODULE_TYPE_CACHE_KEY, function () {
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
         Cache::forever(self::MODULE_TYPE_CACHE_KEY, $type->value);
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
 }
