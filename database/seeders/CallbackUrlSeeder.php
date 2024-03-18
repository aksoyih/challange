<?php

namespace Database\Seeders;

use App\Models\CallbackUrl;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CallbackUrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CallbackUrl::create([
            'event' => 'started',
            'url' => 'https://webhook-test.com/41cde5e0cdb39c1fcecd4103afaf4ffe',
        ]);

        CallbackUrl::create([
            'event' => 'renewed',
            'url' => 'https://webhook-test.com/41cde5e0cdb39c1fcecd4103afaf4ffe',
        ]);

        CallbackUrl::create([
            'event' => 'cancelled',
            'url' => 'https://webhook-test.com/41cde5e0cdb39c1fcecd4103afaf4ffe',
        ]);
    }
}
