<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->assignRole('super-admin')->create();

        User::factory()->count(2)->assignRole('admin')->create();

        User::factory()->count(50)->assignRole('subscriber')->create();
    }
}
