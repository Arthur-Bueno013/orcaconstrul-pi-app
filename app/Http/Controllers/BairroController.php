<?php
namespace App\Http\Controllers;

use App\Models\Bairro;
use App\Http\Requests\StoreBairroRequest;
use App\Http\Requests\UpdateBairroRequest;

class BairroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Pegar a lista do banco
        $bairros = Bairro::all();

        //Retornar lista em formato json
        return response()->json(['data' => $bairros]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBairroRequest $request)
    {
        // Crie um novo Tipo
        $bairro = Bairro::create($request->all());

        // Retorne o codigo 201
        return response()->json($bairro, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // procure tipo por id
        $bairro = Bairro::find($id);

        if (!$bairro) {
            return response()->json(['message' => 'Bairro não encontrado'], 404);
        }

        return response()->json($bairro);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBairroRequest $request, $id)
    {
        // Procure o tipo pela id
        $bairro = Bairro::find($id);

        if (!$bairro) {
            return response()->json(['message' => 'Bairro não encontrado'], 404);
        }

        // Faça o update do tipo
        $bairro->update($request->all());

        // Retorne o tipo
        return response()->json($bairro);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       // Encontre um tipo pelo ID
       $bairro = Bairro::find($id);

       if (!$bairro) {
           return response()->json(['message' => 'Bairro não encontrado!'], 404);
       }  

       //Se tiver dependentes deve retornar erro
 
       // Delete the brand
       $bairro->delete();

       return response()->json(['message' => 'Bairro deletado com sucesso!'], 200);
    }
}