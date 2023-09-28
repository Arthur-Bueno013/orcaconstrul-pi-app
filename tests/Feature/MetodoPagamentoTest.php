<?php

namespace Tests\Feature;
use App\Models\Metodopagamento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MetodopagamentoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase, WithFaker;

    public function testListarTodosMetodopaamentos()
    {
        //Criar 5 metodopagamentos
        //Salvar Temporario
        Metodopagamento::factory()->count(5)->create();

        // usar metodo GET para verificar o retorno
        $response = $this->getJson('/api/metodopagamentos');

        //Testar ou verificar saida
        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'descricao','created_at', 'updated_at']
                ]
            ]);
    }
    public function testCriarMetodopagamentoSucesso()
    {
    
        //Criar o objeto
        $data = [
            'descricao' => $this->faker->word 
        ];
    

        //dd($data);
    
        // Fazer uma requisição POST
        $response = $this->postJson('/api/metodopagamentos', $data);
    
        //dd($response);
    
        // Verifique se teve um retorno 201 - Criado com Sucesso
        // e se a estrutura do JSON Corresponde
        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'descricao', 'created_at', 'updated_at']);
    }


    public function testCriacaoMetodopagamentoFalha()
    {
        $data = [
            "descricao" => '',
        ];
        // Fazer uma requisição POST
        $response = $this->postJson('/api/metodopagamentos', $data);

        // Verifique se teve um retorno 422 - Falha no salvamento
        // e se a estrutura do JSON Corresponde
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['descricao']);
    }
    public function testPesquisaMetodopagamentoSucesso()
    {
        // Criar um metodopagamento
        $metodopagamento = Metodopagamento::factory()->create();
        // Fazer pesquisa
        $response = $this->getJson('/api/metodopagamentos/' . $metodopagamento->id);
        // Verificar saida
        $response->assertStatus(200)
            ->assertJson([
                'id' => $metodopagamento->id,
                'descricao' => $metodopagamento->descricao,
            ]);
    }
    public function testPesquisaMetodopagamentoComFalha()
    {
        // Fazer pesquisa com um id inexistente
        $response = $this->getJson('/api/metodopagamentos/999'); // o 999 nao pode existir
        // Veriicar a resposta
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Metodopagamento não encontrado'
            ]);
    }
    /**
     *Teste de upgrade com sucesso
     *
     * @return void
     */
    public function testUpdateMetodopagamentoSucesso()
    {
        // Crie um metodopagamento fake
        $metodopagamento = Metodopagamento::factory()->create();

        // Dados para update
        $newData = [
            'descricao' => 'Metodopagamento Descricao',

        ];
        // Faça uma chamada PUT
        $response = $this->putJson('/api/metodopagamentos/' . $metodopagamento->id, $newData);
        // Verifique a resposta
        $response->assertStatus(200)
            ->assertJson([
                'id' => $metodopagamento->id,
                'descricao' => 'Metodopagamento Descricao',
            ]);
    }
    public function testUpdateMetodopagamentoDataInvalida()
    {
        // Crie um bai$metodopagamento falso
        $metodopagamento = Metodopagamento::factory()->create();

        // Crie dados falhos
        $invalidData = [
            'descricao' => '', // Invalido: Metodopagamento vazio
        ];

        // faça uma chamada PUT
        $response = $this->putJson('/api/metodopagamentos/' . $metodopagamento->id, $invalidData);

        // Verificar se teve um erro 422
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['descricao']);
    }

    /**
     * Teste update de bai$metodopagamento
     *
     * @return void
     */
    public function testUpdateMetodopagamentoNaoExistente()
    {
        // Faça uma chamada para um id falho
        $response = $this->putJson('/api/metodopagamentos/999', ['descricao' => 'Metodopagamento Descricao']); //O 999 não deve existir

        // Verificar o retorno 404
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Metodopagamento não encontrado'
            ]);
    }
    public function testUpdateMetodoPagamentoMesmosDados()
    {
        // Crie um tipo fake
        $metodopagamento = Metodopagamento::factory()->create();

        // Data para update
        $sameData = [
            'descricao' => $metodopagamento->descricao,
        ];

        // Faça uma chamada PUT
        $response = $this->putJson('/api/metodopagamentos/' . $metodopagamento->id, $sameData);

        // Verifique a resposta
        $response->assertStatus(200)
            ->assertJson([
                'id' => $metodopagamento->id,
            'descricao' => $metodopagamento->descricao
            ]);
    }

    /**
     * Teste upgrade com descricao duplicado
     *
     * @return void
     */
    public function testUpdateMetodopagamentoDescricaoDuplicada()
    {
        // Crie dois metodopagamentos fakes
        $metodopagamentoExistente = Metodopagamento::factory()->create();
        $metodopagamentoUpgrade = Metodopagamento::factory()->create();

        // Para para upgrade
        $newData = [
            'descricao' => $metodopagamentoExistente->metodopagamento,
        ];

        // Faça o put 
        $response = $this->putJson('/api/metodopagamentos/' . $metodopagamentoUpgrade->id, $newData);

        // Verifique a resposta
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['descricao']);
    }
    public function testDeleteMetodopagamento()
    {
        // Criar metodopagamento fake
        $metodopagamento = Metodopagamento::factory()->create();

        // enviar requisição para Delete
        $response = $this->deleteJson('/api/metodopagamentos/' . $metodopagamento->id);

        // Verifica o Detele
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Metodopagamento deletado com sucesso!'
            ]);

        //Verifique se foi deletado do banco
        $this->assertDatabaseMissing('metodo_pagamentos', ['id' => $metodopagamento->id]);
    }

    /**
     * Teste remoção de registro inexistente
     *
     * @return void
     */
    public function testDeleteMetodopagamentoNaoExistente()
    {
        // enviar requisição para Delete
        $response = $this->deleteJson('/api/metodopagamentos/999');

        // Verifique a resposta
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Metodopagamento não encontrado!'
            ]);
    }
}