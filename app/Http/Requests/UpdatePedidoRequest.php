<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'numero' => 'integer|unique:pedidos,numero,' . $this->route('pedido') . ',id|required',
            'data' => 'required|date',
            'status' => 'required|integer',
            'total' => 'required|numeric',
            'detalhes_pedido.*.pedido_id' => 'required|exists:pedidos,id',
            'detalhes_pedido.*.produto_id' => 'required|exists:produtos,id',
            'detalhes_pedido.*.bairro_id' =>  'required|exists:bairros,id',
            'detalhes_pedido.*.quantidade' => 'required|integer|min:1',
            'detalhes_pedido.*.preco' => 'required|numeric',
            'detalhes_pedido.*.total' => 'required|numeric',
        ];
    }
}