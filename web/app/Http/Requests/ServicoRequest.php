<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mes' => 'required|integer',
            'limit' => 'required|integer'
        ];
    }

    /**
     * Retorno mensagem obrigatoria na request
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'O :attribute não pode estar vazio e/ou tem que ser somente numeros.',
        ];
    }
}
