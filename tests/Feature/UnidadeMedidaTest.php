<?php

namespace Tests\Feature;

use App\Models\Produto;
use App\Models\UnidadeMedida;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UnidadeMedidaTest extends TestCase

{
    use RefreshDatabase, WithFaker;

    public function testListarTodosUnidadeMedida()
    {
        //Criar 5 Avaliacaos
        //Salvar Temporario
        UnidadeMedida::factory()->count(5)->create();

        // usar metodo GET para verificar o retorno
        $response = $this->getJson('/api/unidade_medidas');

        //Testar ou verificar saida
        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'mt','kg','produto_id', 'created_at', 'updated_at']
                ]
            ]);
    }

    /**
     * Criar um Avaliacao
     */
    public function testCriarUnidadeMedidaSucesso()
    {

        //Criar produto
        $produto = Produto::factory()->create();
        //Criar o objeto
        $data = [
            'kg' => $this->faker->randomFloat(2, 0, 1000),
            'kg' => $this->faker->randomFloat(2, 0, 1000),
            'produto_id' => $produto->id
        ];

        //Debug
        //dd($data);

        // Fazer uma requisição POST
        $response = $this->postJson('/api/unidade_medidas', $data);

        //dd($response);

        // Verifique se teve um retorno 201 - Criado com Sucesso
        // e se a estrutura do JSON Corresponde
        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'mt','kg','produto_id', 'created_at', 'updated_at']);
    }

     /**
     * Criar um Avaliacao com falha
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
