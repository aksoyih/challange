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

        $expireDate = $this->faker->dateTimeBetween('-2 month', '+2 month');
        $status = $expireDate < now() ? 'expired' : 'active';

        return [
            'app_id' => $app,
            'device_id' => $device,
            'receipt' => rand(100000000, 999999999),
            'expire_date' => $expireDate,
            'status' => $status,
        ];
    }
}
