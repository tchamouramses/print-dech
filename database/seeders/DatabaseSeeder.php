<?php

namespace Database\Seeders;

use App\Models\Enums\MoveRangeEnum;
use App\Models\MoveType;
use App\Models\PointOfSale;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Symfony\Component\HttpKernel\Profiler\Profile;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProfilSeeder::class,
        ]);

        PointOfSale::create([
            'name' => 'Baleving'
        ]);
        PointOfSale::create([
            'name' => 'Dschang'
        ]);
        PointOfSale::create([
            'name' => 'Penka Michel'
        ]);

        MoveType::create([
            'name' => 'Espece',
            'range' => MoveRangeEnum::INTERNAL->value,
        ]);

        MoveType::create([
            'name' => 'Flotte',
            'range' => MoveRangeEnum::INTERNAL->value,
        ]);
    }
}
