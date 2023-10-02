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
                    '*' => ['id', 'descricao', 'created_at', 'updated_at']
                ]
            ]);
    }

    /**
     * Criar um Avaliacao
     */
    public function testCriarUnidadeMedidaSucesso()
    {


        //Criar o objeto
        $data = [
            'descricao' => $this->faker->unique()->word(),
        ];

        //Debug
        //dd($data);

        // Fazer uma requisição POST
        $response = $this->postJson('/api/unidade_medidas', $data);

        //dd($response);

        // Verifique se teve um retorno 201 - Criado com Sucesso
        // e se a estrutura do JSON Corresponde
        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'descricao', 'created_at', 'updated_at']);
    }


    /**
     * Criar um Avaliacao com falha
     */
    public function testCriarUnidadeMedidaFalha()
    {


        //Criar o objeto
        $data = [
            'descricao' => "",
        ];

        //Debug
        //dd($data);

        // Fazer uma requisição POST
        $response = $this->postJson('/api/unidade_medidas', $data);

        //dd($response);

        // Verifique se teve um retorno 201 - Criado com Sucesso
        // e se a estrutura do JSON Corresponde
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['descricao']);
    }


    /**
     * Teste de deletar com sucesso
     *
     * @return void
     */
    public function testDeleteUnidadeMedida()
    {
        // Criar avaliacao fake
        $unidadeMedida = UnidadeMedida::factory()->create();

        // enviar requisição para Delete
        $response = $this->deleteJson('/api/unidade_medidas/' . $unidadeMedida->id);

        // Verifica o Detele
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Unidade deletada com sucesso!'
            ]);

        //Verifique se foi deletado do banco
        $this->assertDatabaseMissing('unidade_medidas', ['id' => $unidadeMedida->id]);
    }

    /**
     * Teste remoção de registro inexistente
     *
     * @return void
     */
    public function testDeleteUnidadeMedidaNaoExistente()
    {
        // enviar requisição para Delete
        $response = $this->deleteJson('/api/unidade_medidas/999');

        // Verifique a resposta
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Unidade não encontrada!'
            ]);
    }
}