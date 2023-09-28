<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnidadeMedidaRequest;
use App\Models\UnidadeMedida;


class UnidadeMedidaController extends Controller

    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            //
            $unidadeMedida = UnidadeMedida::all();
    
            //Retornar lista em formato json
            return response()->json(['data' => $unidadeMedida]);
        }
    
        /**
         * Store a newly created resource in storage.
         */
        public function store(StoreUnidadeMedidaRequest $request)
        {
            // Crie um novo Tipo
            $unidadeMedida = UnidadeMedida::create($request->all());
    
            // Retorne o codigo 201
            return response()->json($unidadeMedida, 201);
        }
    
        /**
         * Remove the specified resource from storage.
         */
        public function destroy($id)
        {
            // Encontre um tipo pelo ID
            $unidadeMedida = UnidadeMedida::find($id);
    
            if (!$unidadeMedida) {
                return response()->json(['message' => 'Unidade não encontrada!'], 404);
            }
    
            //Se tiver dependentes deve retornar erro
    
            // Delete the brand
            $unidadeMedida->delete();
    
            return response()->json(['message' => 'Unidade deletada com sucesso!'], 200);
        }
    }