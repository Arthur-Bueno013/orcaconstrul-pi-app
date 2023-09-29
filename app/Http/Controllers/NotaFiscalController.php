<?php

namespace App\Http\Controllers;

use App\Models\NotaFiscal;
use App\Http\Requests\StoreNotaFiscalRequest;
use App\Http\Requests\UpdateNotaFiscalRequest;

class NotaFiscalController extends Controller

    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            //
            $notaFiscal = NotaFiscal::all();
    
            //Retornar lista em formato json
            return response()->json(['data' => $notaFiscal]);
        }
    
        /**
         * Store a newly created resource in storage.
         */
        public function store(StoreNotaFiscalRequest $request)
        {
            // Crie um novo Tipo
            $notaFiscal = NotaFiscal::create($request->all());
    
            // Retorne o codigo 201
            return response()->json($notaFiscal, 201);
        }
    
        /**
         * Remove the specified resource from storage.
         */
        public function destroy($id)
        {
            // Encontre um tipo pelo ID
            $notaFiscal = NotaFiscal::find($id);
    
            if (!$notaFiscal) {
                return response()->json(['message' => 'Nota não encontrada!'], 404);
            }
    
            //Se tiver dependentes deve retornar erro
    
            // Delete the brand
            $notaFiscal->delete();
    
            return response()->json(['message' => 'Nota deletada com sucesso!'], 200);
        }
    }
