<?php

namespace Tests\Feature;

use App\Models\DetalhePedido;
use App\Models\Pedido;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PedidoTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    public function test_listar_pedidos()
    {
        // Crie alguns pedidos fictícios no banco de dados
        $pedidos = Pedido::factory(3)->create();

        foreach ($pedidos as $pedido) {
            DetalhePedido::factory(2)->create(['pedido_id' => $pedido->id]);
        }

        // Faça uma solicitação GET para listar os pedidos
        $response = $this->getJson('/api/pedidos');

        // Verifique se a resposta está correta
        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(3, 'data'); // Verifica se há 3 pedidos na resposta
    }

    public function test_criar_pedido()
    {
        // Dados fictícios para criar um pedido
        $pedidoData = Pedido::factory()->make()->toArray();

        // Dados fictícios para detalhes do pedido
        $detalhesPedidoData = [
            DetalhePedido::factory()->make()->toArray(),
            DetalhePedido::factory()->make()->toArray(),
        ];

        $data = array_merge($pedidoData, ['detalhes_pedido' => $detalhesPedidoData]);

        // Faça uma solicitação POST para criar um pedido
        $response = $this->postJson('/api/pedidos', $data);

        // Verifique se o pedido foi criado com sucesso
        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'numero', 'data', 'status', 'total', 'created_at', 'updated_at',
                'detalhes_pedido' => [
                    '*' => [
                        'id', 'bairro_id', 'produto_id', 'quantidade', 'preco', 'total', 'created_at', 'updated_at',
                    ],
                ],
            ]);
    }

    public function test_mostrar_pedido()
    {
        // Crie um pedido fictício no banco de dados
        $pedido = Pedido::factory()->create();
        DetalhePedido::factory(2)->create(['pedido_id' => $pedido->id]);

        // Faça uma solicitação GET para mostrar o pedido
        $response = $this->getJson("/api/pedidos/{$pedido->id}");

        // Verifique se a resposta está correta
        $response->assertStatus(200)
            ->assertJsonStructure([
                'id', 'numero', 'data', 'status', 'total', 'created_at', 'updated_at',
                'detalhes_pedido' => [
                    '*' => [
                        'id', 'bairro_id', 'produto_id', 'quantidade', 'preco', 'total', 'created_at', 'updated_at',
                    ],
                ],
            ]);
    }

    public function test_atualizar_pedido()
    {
        // Crie um pedido fictício no banco de dados
        $pedido = Pedido::factory()->create();
        DetalhePedido::factory(2)->create(['pedido_id' => $pedido->id]);

        // Dados fictícios para atualizar o pedido
        $pedidoAtualizado = Pedido::factory()->make()->toArray();

        // Dados fictícios para detalhes do pedido atualizado
        $detalhesPedidoAtualizado = [
            DetalhePedido::factory()->make()->toArray(),
            DetalhePedido::factory()->make()->toArray(),
        ];

        $data = array_merge($pedidoAtualizado, ['detalhes_pedido' => $detalhesPedidoAtualizado]);

        // Faça uma solicitação PUT para atualizar o pedido
        $response = $this->putJson("/api/pedidos/{$pedido->id}", $data);

        // Verifique se o pedido foi atualizado com sucesso
        $response->assertStatus(200)
            ->assertJsonStructure([
                'id', 'numero', 'data', 'status', 'total', 'created_at', 'updated_at',
                'detalhes_pedido' => [
                    '*' => [
                        'id', 'bairro_id', 'produto_id', 'quantidade', 'preco', 'total', 'created_at', 'updated_at',
                    ],
                ],
            ]);
    }

    public function test_deletar_pedido()
    {
        // Crie um pedido fictício no banco de dados
        $pedido = Pedido::factory()->create();
        DetalhePedido::factory(2)->create(['pedido_id' => $pedido->id]);

        // Faça uma solicitação DELETE para excluir o pedido
        $response = $this->deleteJson("/api/pedidos/{$pedido->id}");

        // Verifique se o pedido foi excluído com sucesso
        $response->assertStatus(200)
            ->assertJson(['message' => 'Pedido deletado com sucesso!']);
    }
}
