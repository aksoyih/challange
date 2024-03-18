<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $device = \App\Models\Device::inRandomOrder()->first();
        $app = $device->app;


        return [
            'app_id' => $app,
            'device_id' => $device,
            'receipt' => rand(100000000, 999999999),
            'token' => $this->faker->regexify('[A-Za-z0-9]{36}') // random token
        ];
    }
}
