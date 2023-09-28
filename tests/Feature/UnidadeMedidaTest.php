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
            //Criar 5 tipos
            //Salvar Temporario
            UnidadeMedida::factory()->count(5)->create();
    
            // usar metodo GET para verificar o retorno
            $response = $this->getJson('/api/unidade_medidas');
    
            //Testar ou verificar saida
            $response->assertStatus(200)
                ->assertJsonCount(5, 'data')
                ->assertJsonStructure([
                    'data' => [
                        '*' => ['id', 'mt','kg', 'created_at', 'updated_at']
                    ]
                ]);
        }
    
    
        /**
         * Criar um Tipo
         */
        public function testCriarUnidadeMedidaSucesso()
        {
    
            // Criar um tipo usando o factory
            $produto = Produto::factory()->create();
    
            //Criar o objeto
            $data = [
                'mt' => $this->faker->randomFloat(2, 10, 1000),
                'kg' => $this->faker->randomFloat(2, 10, 1000),
                'produto_id' => $produto->id
            ];
    
    
            // Fazer uma requisição POST
            $response = $this->postJson('/api/unidade_medidas', $data);
    
            //dd($response);
    
            // Verifique se teve um retorno 201 - Criado com Sucesso
            // e se a estrutura do JSON Corresponde
            $response->assertStatus(201)
                ->assertJsonStructure(['id', 'mt', 'kg', 'produto_id', 'created_at', 'updated_at']);
        }
    
        /**
         * Teste de criação com falhas
         *
         * @return void
         */
        public function testCriacaoProdutoFalha()
        {
            $data = [
                "mt" => '',
                "kg" => '',
                "produto_id" => ''
            ];
            // Fazer uma requisição POST
            $response = $this->postJson('/api/unidade_medidas', $data);
    
            // Verifique se teve um retorno 422 - Falha no salvamento
            // e se a estrutura do JSON Corresponde
            $response->assertStatus(422)
                ->assertJsonValidationErrors(['mt', 'kg', 'produto_id']);
        }
    
        /**
         * Teste de pesquisa de registro
         *
         * @return void
         */
        public function testPesquisaUnidadeMedidaSucesso()
        {
            // Criar um tipo
            $unidade_medida = UnidadeMedida::factory()->create();
    
            // Fazer pesquisa
            $response = $this->getJson('/api/unidade_medidas/' . $unidade_medida->id);
    
            // Verificar saida
            $response->assertStatus(200)
                ->assertJson([
                    'id' => $unidade_medida->id,
                    'preco' => $unidade_medida->preco,
                    'estoque' => $unidade_medida->estoque,
                    'produto_id' => $unidade_medida->produto_id,
                ]);
        }
    
    
        /**
         * Teste de pesquisa de registro com falha
         *
         * @return void
         */
        public function testPesquisaProdutoComFalha()
        {
            // Fazer pesquisa com um id inexistente
            $response = $this->getJson('/api/unidade_medidas/999'); // o 999 nao pode existir
    
            // Veriicar a resposta
            $response->assertStatus(404)
                ->assertJson([
                    'message' => 'Unidade não encontrada'
                ]);
        }
    
        /**
         *Teste de upgrade com sucesso
         *
         * @return void
         */
        public function testUpdateUnidadeMedidaSucesso()
        {
            // Crie um produto fake
            $unidade_medida = UnidadeMedida::factory()->create();
    
            // Dados para update
            $newData = [
                'mt' => 3.55,
                'kg' => 5.90,
                'produto_id' => $unidade_medida->produto->id
    
            ];
    
            // Faça uma chamada PUT
            $response = $this->putJson('/api/unidade_medidas/' . $unidade_medida->id, $newData);
    
            // Verifique a resposta
            $response->assertStatus(200)
                ->assertJson([
                    'id' => $unidade_medida->id,
                    'mt' => 3.55,
                    'kg' => 5.90,
                    'produto_id' => $unidade_medida->produto->id
                ]);
        }
    
        /**
         *Teste de upgrade com falhas
         *
         * @return void
         */
        public function testUpdateUnidadeMedidaComFalhas()
        {
            // Crie um produto fake
            $unidade_medida = UnidadeMedida::factory()->create();
    
            // Dados para update      
            $invalidData = [
                "mt" => '',
                "kg" => '',
                "produto_id" => 0
    
            ];
            // Faça uma chamada PUT
            $response = $this->putJson('/api/unidade_medidas/' . $unidade_medida->id, $invalidData);
    
            // Verificar se teve um erro 422
            $response->assertStatus(422)
                ->assertJsonValidationErrors(['mt', 'kg','produto_id']);
        }
    
        /**
         * Teste update de produto
         *
         * @return void
         */
        public function testUpdateUnidadeMedidaNaoExistente()
        {
    
            // Criar um tipo usando o factory
            $produto = Produto::factory()->create();
    
    
            // Dados para update
            $newData = [ 
            
                'mt' => 3.55,
                'kg' => 5.90,
                'produto_id' => $produto->id
    
            ];
            // Faça uma chamada PUT
            $response = $this->putJson('/api/unidade_medidas/9999', $newData);
    
            // Verificar o retorno 404
            $response->assertStatus(404)
                ->assertJson([
                    'message' => 'Unidade não encontrada'
                ]);
        }
    
    
        /**
         * Teste de upgrade com os mesmos nome
         *
         * @return void
         */
        public function testUpdateProdutoMesmoNome()
        {
            // Crie um tipo fake
            $produto = Produto::factory()->create();
    
            // Data para update
            $sameData = [
                'nome' => $produto->nome,
                'descricao' =>
                $produto->descricao,
                'preco' =>
                $produto->preco,
                'estoque' =>
                $produto->estoque,
                'tipo_id'
                => $produto->tipo->id,
            ];
    
            // Faça uma chamada PUT
            $response = $this->putJson('/api/unidade_medidas/' . $produto->id, $sameData);
    
            // Verifique a resposta
            $response->assertStatus(200)
                ->assertJson([
                    'id' => $produto->id,
                    'nome' => $produto->nome,
                    'descricao' =>
                    $produto->descricao,
                    'preco' =>
                    $produto->preco,
                    'estoque' =>
                    $produto->estoque,
                    'tipo_id'
                    => $produto->tipo->id,
                ]);
        }
    
        /**
         * Teste de upgrade com o nome duplicado
         *
         * @return void
         */
        public function testUpdateProdutoNomeDuplicado()
        {
            // Crie um tipo fake
            $produto = Produto::factory()->create();
            $atualizar = Produto::factory()->create();
    
            // Data para update
            $sameData = [
                'nome' => $produto->nome,
                'descricao' => $produto->descricao,
                'preco' => $produto->preco,
                'estoque' =>   $produto->estoque,
                'tipo_id' => $produto->tipo->id
            ];
    
            // Faça uma chamada PUT
            $response = $this->putJson('/api/unidade_medidas/' . $atualizar->id, $sameData);
    
            // Verifique a resposta
            $response->assertStatus(422)
                ->assertJsonValidationErrors(['nome']);
        }
    
        /**
         * Teste de deletar com sucesso
         *
         * @return void
         */
        public function testDeleteProduto()
        {
            // Criar produto fake
            $produto = Produto::factory()->create();
    
            // enviar requisição para Delete
            $response = $this->deleteJson('/api/unidade_medidas/' . $produto->id);
    
            // Verifica o Delete
            $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Produto deletado com sucesso!'
                ]);
    
            //Verifique se foi deletado do banco
            $this->assertDatabaseMissing('unidade_medidas', ['id' => $produto->id]);
        }
    
        /**
         * Teste remoção de registro inexistente
         *
         * @return void
         */
        public function testDeleteProdutoNaoExistente()
        {
            // enviar requisição para Delete
            $response = $this->deleteJson('/api/unidade_medidas/999');
    
            // Verifique a resposta
            $response->assertStatus(404)
                ->assertJson([
                    'message' => 'Produto não encontrado!'
                ]);
        }
    }
