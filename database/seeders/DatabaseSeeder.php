<?php

namespace Database\Seeders;

use App\Models\CallbackUrl;
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
        $this->call([
            AppSeeder::class,
            CallbackUrlSeeder::class,
        ]);

        // \App\Models\Device::factory(50)->create();
        // \App\Models\Subscription::factory(100)->create();
    }
}
