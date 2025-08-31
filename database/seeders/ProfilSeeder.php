<?php

namespace Database\Seeders;

use App\Models\Profil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profil::create([
            'name' => 'SOCIETE DECH SARL',
            'phone1' => '674 83 91 66',
            'phone2' => '694 89 54 51',
            'niu' => 'M042116025003G',
            'service' => 'Prestations de services - Papeterie-Commerce générale',
            'head_office' => 'Penka - Michel',
            'trade_register' => 'RC/Dschang/2021/B/46',
        ]);
    }
}
