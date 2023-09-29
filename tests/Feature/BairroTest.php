<?php

namespace Tests\Feature;
use App\Models\Bairro;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BairroTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase, WithFaker;

    public function testListarTodosBairros()
    {
        //Criar 5 bairros
        //Salvar Temporario
        Bairro::factory()->count(5)->create();

        // usar metodo GET para verificar o retorno
        $response = $this->getJson('/api/bairros');

        //Testar ou verificar saida
        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'nome', 'created_at', 'updated_at']
                ]
            ]);
    }
    public function testCriarBairroSucesso()
    {
    
        //Criar o objeto
        $data = [
            "nome" => $this->faker->word
        ];
    
        //Debug
        //dd($data);
    
        // Fazer uma requisição POST
        $response = $this->postJson('/api/bairros', $data);
    
        //dd($response);
    
        // Verifique se teve um retorno 201 - Criado com Sucesso
        // e se a estrutura do JSON Corresponde
        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'nome', 'created_at', 'updated_at']);
    }
    public function testCriacaoBairroFalha()
    {
        $data = [
            "nome" => 'a'
        ];
        // Fazer uma requisição POST
        $response = $this->postJson('/api/bairros', $data);

        // Verifique se teve um retorno 422 - Falha no salvamento
        // e se a estrutura do JSON Corresponde
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nome']);
    }
    public function testPesquisaBairroSucesso()
    {
        // Criar um bairro
        $bairro = Bairro::factory()->create();
        // Fazer pesquisa
        $response = $this->getJson('/api/bairros/' . $bairro->id);
        // Verificar saida
        $response->assertStatus(200)
            ->assertJson([
                'id' => $bairro->id,
                'nome' => $bairro->nome,
            ]);
    }
    public function testPesquisaBairroComFalha()
    {
        // Fazer pesquisa com um id inexistente
        $response = $this->getJson('/api/bairros/999'); // o 999 nao pode existir
        // Veriicar a resposta
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Bairro não encontrado'
            ]);
    }
    /**
     *Teste de upgrade com sucesso
     *
     * @return void
     */
    public function testUpdateBairroSucesso()
    {
        // Crie um bairro fake
        $bairro = Bairro::factory()->create();

        // Dados para update
        $newData = [
            'nome' => 'Bairro Nome',
        ];
        // Faça uma chamada PUT
        $response = $this->putJson('/api/bairros/' . $bairro->id, $newData);
        // Verifique a resposta
        $response->assertStatus(200)
            ->assertJson([
                'id' => $bairro->id,
                'nome' => 'Bairro Nome',
            ]);
    }
    public function testUpdateBairroDataInvalida()
    {
        // Crie um bai$bairro falso
        $bairro = Bairro::factory()->create();

        // Crie dados falhos
        $invalidData = [
            'nome' => '', // Invalido: Bairro vazio
        ];

        // faça uma chamada PUT
        $response = $this->putJson('/api/bairros/' . $bairro->id, $invalidData);

        // Verificar se teve um erro 422
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nome']);
    }

    /**
     * Teste update de bai$bairro
     *
     * @return void
     */
    public function testUpdateBairroNaoExistente()
    {
        // Faça uma chamada para um id falho
        $response = $this->putJson('/api/bairros/999', ['nome' => 'Bairro Nome']); //O 999 não deve existir

        // Verificar o retorno 404
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Bairro não encontrado'
            ]);
    }
    public function testUpdateBairroMesmosDados()
    {
        // Crie um bairro fake
        $bairro = Bairro::factory()->create();

        // Data para update
        $sameData = [
            'nome' => $bairro->nome,
        ];

        // Faça uma chamada PUT
        $response = $this->putJson('/api/bairros/' . $bairro->id, $sameData);

        // Verifique a resposta
        $response->assertStatus(200)
            ->assertJson([
                'id' => $bairro->id,
            'nome' => $bairro->nome
            ]);
    }

    /**
     * Teste upgrade com nome duplicado
     *
     * @return void
     */
    public function testUpdateBairroDescricaoDuplicada()
    {
        // Crie dois bairros fakes
        $bairroExistente = Bairro::factory()->create();
        $bairroUpgrade = Bairro::factory()->create();

        // Para para upgrade
        $newData = [
            'nome' => $bairroExistente->bairro,
        ];

        // Faça o put 
        $response = $this->putJson('/api/bairros/' . $bairroUpgrade->id, $newData);

        // Verifique a resposta
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nome']);
    }
    public function testDeleteBairro()
    {
        // Criar bairro fake
        $bairro = Bairro::factory()->create();

        // enviar requisição para Delete
        $response = $this->deleteJson('/api/bairros/' . $bairro->id);

        // Verifica o Detele
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Bairro deletado com sucesso!'
            ]);

        //Verifique se foi deletado do banco
        $this->assertDatabaseMissing('bairros', ['id' => $bairro->id]);
    }

    /**
     * Teste remoção de registro inexistente
     *
     * @return void
     */
    public function testDeleteBairroNaoExistente()
    {
        // enviar requisição para Delete
        $response = $this->deleteJson('/api/bairros/999');

        // Verifique a resposta
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Bairro não encontrado!'
            ]);
    }

}


