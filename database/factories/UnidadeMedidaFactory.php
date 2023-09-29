<?php

namespace Database\Factories;

use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UnidadeMedida>
 */
class UnidadeMedidaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'mt' => $this->faker->randomFloat(2, 10, 1000),
            'kg' => $this->faker->randomFloat(2, 10, 1000),
            'produto_id' => function () {
                return Produto::factory()->create()->id;
            }


        ];
    }
}
