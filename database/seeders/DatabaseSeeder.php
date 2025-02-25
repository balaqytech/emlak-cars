<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->run(ShieldSeeder::class);

        User::factory()->create([
            'name' => 'As3ad',
            'email' => 'as3ad.moh@gmail.com',
            'password' => bcrypt('123123123'),
        ]);
    }
}
