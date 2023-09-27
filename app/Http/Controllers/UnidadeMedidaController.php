<?php

namespace App\Http\Controllers;

use App\Models\UnidadeMedida;
use App\Http\Requests\StoreUnidadeMedidaRequest;
use App\Http\Requests\UpdateUnidadeMedidaRequest;


class UnidadeMedidaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Pegar a lista do banco
        $unidade_medida = UnidadeMedida::all();

        //Retornar lista em formato json
        return response()->json(['data' => $unidade_medida]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnidadeMedidaRequest $request)
    {
        // Crie um novo Tipo
        $unidade_medida = UnidadeMedida::create($request->all());

        // Retorne o codigo 201
        return response()->json($unidade_medida, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // procure tipo por id
        $unidade_medida = UnidadeMedida::find($id);

        if (!$unidade_medida) {
            return response()->json(['message' => 'Unidade não encontrado'], 404);
        }

        return response()->json($unidade_medida);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnidadeMedidaRequest $request, $id)
    {
        // Procure o tipo pela id
        $unidade_medida = UnidadeMedida::find($id);

        if (!$unidade_medida) {
            return response()->json(['message' => 'Unidade não encontrado'], 404);
        }

        // Faça o update do tipo
        $unidade_medida->update($request->all());

        // Retorne o tipo
        return response()->json($unidade_medida);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       // Encontre um tipo pelo ID
       $unidade_medida = UnidadeMedida::find($id);

       if (!$unidade_medida) {
           return response()->json(['message' => 'Unidade não encontrado!'], 404);
       }  

       //Se tiver dependentes deve retornar erro
 
       // Delete the brand
       $unidade_medida->delete();

       return response()->json(['message' => 'Unidade deletado com sucesso!'], 200);
    }
}