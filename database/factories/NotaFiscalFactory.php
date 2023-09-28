<?php

namespace Database\Factories;

use App\Models\Bairro;
use App\Models\Pedido;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NotaFiscal>
 */
class NotaFiscalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'usuario_id'=> function () {
                return Usuario::factory()->create()->id; 
            },
            'pedido_id'=> function () {
                return Pedido::factory()->create()->id;         
            },
            'bairro_id'=> function () {
                return Bairro::factory()->create()->id;
            },
            'chave_pagamento' => "". $this->faker->word." " ,
        
        ];
    }
}
