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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        CallbackUrl::factory()->create([
            'event' => 'started',
            'url' => 'https://webhook-test.com/41cde5e0cdb39c1fcecd4103afaf4ffe',
        ]);

        CallbackUrl::factory()->create([
            'event' => 'renewed',
            'url' => 'https://webhook-test.com/41cde5e0cdb39c1fcecd4103afaf4ffe',
        ]);

        CallbackUrl::factory()->create([
            'event' => 'cancelled',
            'url' => 'https://webhook-test.com/41cde5e0cdb39c1fcecd4103afaf4ffe',
        ]);

        $this->call([
            AppSeeder::class,
        ]);

        \App\Models\Device::factory(50)->create();
        \App\Models\Subscription::factory(100)->create();
    }
}
