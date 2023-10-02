<?php

namespace Tests\Feature;

use App\Models\NotaFiscal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NotaFiscalTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testListarTodosNotaFiscal()
    {
        //Criar 5 Avaliacaos
        //Salvar Temporario
        NotaFiscal::factory()->count(5)->create();

        // usar metodo GET para verificar o retorno
        $response = $this->getJson('/api/nota_fiscals');

        //Testar ou verificar saida
        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'usuario_id','pedido_id','bairro_id','chave_pagamento', 'created_at', 'updated_at']
                ]
            ]);
    }

    /**
     * Criar um Avaliacao
     */
    public function testCriarNotaFiscalSucesso()
    {

        //Criar produto
        $notaFiscal = NotaFiscal::factory()->create();
        //Criar o objeto
        $data = [
            
            'usuario_id' => $notaFiscal->id,
            'pedido_id' => $notaFiscal->id, 
            'bairro_id' => $notaFiscal->id,
            'chave_pagamento' => "". $this->faker->word." " 
        ];

        //Debug
        //dd($data);

        // Fazer uma requisição POST
        $response = $this->postJson('/api/nota_fiscals', $data);

        //dd($response);

        // Verifique se teve um retorno 201 - Criado com Sucesso
        // e se a estrutura do JSON Corresponde
        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'usuario_id','pedido_id','bairro_id','chave_pagamento', 'created_at', 'updated_at']);
    }

     /**
     * Criar um Avaliacao com falha
     */
    public function testCriarNotaFiscalFalha()
    {
        //Criar produto
        $notaFiscal = NotaFiscal::factory()->create();
        //Criar o objeto
        $data = [
            
            'usuario_id' => 0,
            'pedido_id' => 0,
            'bairro_id' => 0,
            'chave_pagamento' => "",
        ];

        //Debug
        //dd($data);

        // Fazer uma requisição POST
        $response = $this->postJson('/api/nota_ficals', $data);

        //dd($response);

        // Verifique se teve um retorno 201 - Criado com Sucesso
        // e se a estrutura do JSON Corresponde
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['usuario_id','pedido_id','bairro_id','chave_pagamento']);
    }

    
    /**
     * Teste de deletar com sucesso
     *
     * @return void
     */
    public function testDeleteNotaFiscal()
    {
        // Criar avaliacao fake
        $notaFiscal = NotaFiscal::factory()->create();

        // enviar requisição para Delete
        $response = $this->deleteJson('/api/nota_ficals/' . $notaFiscal->id);

        // Verifica o Detele
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Nota deletada com sucesso!'
            ]);

        //Verifique se foi deletado do banco
        $this->assertDatabaseMissing('nota', ['id' => $notaFiscal->id]);
    }

    /**
     * Teste remoção de registro inexistente
     *
     * @return void
     */
    public function testDeleteUnidadeMedidaNaoExistente()
    {
        // enviar requisição para Delete
        $response = $this->deleteJson('/api/nota_ficals/999');

        // Verifique a resposta
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Nota não encontrada!'
            ]);
    }
}
