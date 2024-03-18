<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\App;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apps = [
            ['name' => 'App X', 'slug' => 'app_x'],
            ['name' => 'App Y', 'slug' => 'app_y'],
            ['name' => 'App Z', 'slug' => 'app_z'],
        ];

        foreach ($apps as $app) {
            App::create($app);
        }
    }
}
