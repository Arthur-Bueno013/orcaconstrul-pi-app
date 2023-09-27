<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Produto;

class ProdutoSeeder extends Seeder
{
    public function run()
    {
        // Criar produtos de exemplo
        Produto::create([
            'detalhe_id' => 1,
            'name' => 'Produto 1',
            'preco' => 100,
            'descricao' => 'Descrição do Produto 1',
            'estoque' => 50,
            'medida_id' => 1,
        ]);

        // Adicionar mais produtos, se necessário
    }
}

