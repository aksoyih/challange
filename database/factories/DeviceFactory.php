<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $app = \App\Models\App::inRandomOrder()->first();

        return [
            'device_uid' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'operating_system' => $this->faker->randomElement(['android', 'ios']),
            'app_id' => $app
        ];
    }
}
