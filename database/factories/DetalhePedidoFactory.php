<?php

namespace Database\Factories;

use App\Models\Bairro;
use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetalhePedido>
 */
class DetalhePedidoFactory extends Factory
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
            'pedido_id' => function () {
                return Pedido::factory()->create()->id;
            },
            'produto_id' => function () {
                return Produto::factory()->create()->id;
            },
            'bairro_id' => function () {
                return Bairro::factory()->create()->id;
            },
            'quantidade' => $this->faker->randomNumber(3),
            'preco' => $this->faker->randomFloat(2, 0, 99),
            'total' => $this->faker->randomFloat(2, 0, 99),
        ];
    }
}
