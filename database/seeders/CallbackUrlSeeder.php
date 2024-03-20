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
            'app_id' => 1,
            'url' => 'https://webhook-test.com/41cde5e0cdb39c1fcecd4103afaf4ffe',
        ]);

        CallbackUrl::create([
            'event' => 'renewed',
            'app_id' => 1,
            'url' => 'https://webhook-test.com/c7SwzdeVUS3BiNJMCRmqPq4iH2ApLcun',
        ]);

        CallbackUrl::create([
            'event' => 'cancelled',
            'app_id' => 1,
            'url' => 'https://webhook-test.com/CGsDKdPbGjYT4cxpdY7bmnSQN9JkAeR4',
        ]);

        CallbackUrl::create([
            'event' => 'started',
            'app_id' => 2,
            'url' => 'https://webhook-test.com/yX7TSSMMYXWnJS2PMBGNaGwdMtVTo2si',
        ]);

        CallbackUrl::create([
            'event' => 'renewed',
            'app_id' => 2,
            'url' => 'https://webhook-test.com/xNVTSb7gKtWF5XMP4vdqpwxcmoQUUATT',
        ]);

        CallbackUrl::create([
            'event' => 'cancelled',
            'app_id' => 2,
            'url' => 'https://webhook-test.com/3RWm8nLWgDBFHkNdMYB737FxyvLc4xfv',
        ]);

        CallbackUrl::create([
            'event' => 'started',
            'app_id' => 3,
            'url' => 'https://webhook-test.com/WeApRjpXQ354jK75qz5bfknxbnH8T4fF',
        ]);

        CallbackUrl::create([
            'event' => 'renewed',
            'app_id' => 3,
            'url' => 'https://webhook-test.com/PtHQ2uPBHpwoUNWL4AZzXryTe4Bo4HKj',
        ]);

        CallbackUrl::create([
            'event' => 'cancelled',
            'app_id' => 3,
            'url' => 'https://webhook-test.com/UN3yGMWJd2wkbvRte3AErFMUiJVRbtUF',
        ]);
    }
}
