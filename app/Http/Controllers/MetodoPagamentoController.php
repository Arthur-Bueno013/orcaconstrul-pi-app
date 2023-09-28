<?php

namespace App\Http\Controllers;

use App\Models\MetodoPagamento;
use App\Http\Requests\StoreMetodoPagamentoRequest;
use App\Http\Requests\UpdateMetodoPagamentoRequest;

class MetodoPagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Pegar a lista do banco
        $metodopagamentos = MetodoPagamento::all();

        //Retornar lista em formato json
        return response()->json(['data' => $metodopagamentos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMetodopagamentoRequest $request)
    {
        // Crie um novo Tipo
        $metodopagamento = MetodoPagamento::create($request->all());

        // Retorne o codigo 201
        return response()->json($metodopagamento, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // procure tipo por id
        $metodopagamento = MetodoPagamento::find($id);

        if (!$metodopagamento) {
            return response()->json(['message' => 'Metodopagamento não encontrado'], 404);
        }

        return response()->json($metodopagamento);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMetodopagamentoRequest $request, $id)
    {
        // Procure o tipo pela id
        $metodopagamento = MetodoPagamento::find($id);

        if (!$metodopagamento) {
            return response()->json(['message' => 'Metodopagamento não encontrado'], 404);
        }

        // Faça o update do tipo
        $metodopagamento->update($request->all());

        // Retorne o tipo
        return response()->json($metodopagamento);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       // Encontre um tipo pelo ID
       $metodopagamento = MetodoPagamento::find($id);

       if (!$metodopagamento) {
           return response()->json(['message' => 'Metodopagamento não encontrado!'], 404);
       }  

       //Se tiver dependentes deve retornar erro   
 
       // Delete the brand
       $metodopagamento->delete();

       return response()->json(['message' => 'Metodo de Pagamento deletado com sucesso!'], 200);
    }
}