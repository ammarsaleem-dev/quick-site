<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicle'=> fake()->randomElement(['Truck1','Truck2','Truck3']),
            'driver_name' => fake()->name(),
            'driver_number' => fake()->phoneNumber()
        ];
    }
}
