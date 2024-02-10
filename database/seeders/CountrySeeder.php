<?php

namespace Database\Seeders;

use App\Models\Pays;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pays::create([
            'nom' => 'togo',
        ]);
    }
}
