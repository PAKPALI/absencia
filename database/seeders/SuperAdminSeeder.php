<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'pays_id' => 1,
            'first_name' => 'Dider',
            'last_name' => 'PAKPALI',
            'email' => 'pakpalididier@gmail.com',
            'password' => bcrypt('Didier@95'),
            'user_type' => 1,
        ]);
    }
}
