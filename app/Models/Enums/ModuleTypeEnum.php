<?php
 namespace App\Models\Enums;

 use Filament\Support\Contracts\HasLabel;
 use Illuminate\Contracts\Support\Htmlable;

 enum ModuleTypeEnum: string implements HasLabel
 {
     case PRINT = 'print';
     case TRANSACTION = 'transaction';
     case STOCK = 'stock';

     public function getLabel(): ?string
     {
         return match ($this) {
             self::PRINT => 'Print',
             self::TRANSACTION => 'Transaction',
             self::STOCK => 'Stock',
         };
     }
 }
