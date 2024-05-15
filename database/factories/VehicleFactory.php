<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory implements SwapiFactoryInterface
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [];
    }

    public function createFromSwapi(array $data, int $pKey): Vehicle
    {
        return $this->create([
            'id' => $pKey,
            'name' => $data['name'] ?? '',
            'model' => $data['model'] ?? '',
            'edited' => substr($data['edited'], 0, 19),
        ]);
    }
}
