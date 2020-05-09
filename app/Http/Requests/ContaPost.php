<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContaPost extends FormRequest
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
            'user_id' =>                'required|bigInteger',
            'nome' =>                   'required|string|max:20'
            'descricao' =>              'required|string|max:255',
            'saldo_abertura' =>         'required|decimal',
            'saldo_atual' =>            'required|decimal',
            'data_ultimo_movimento' =>  'required|date',
            'deleted_at' =>             'required|timestamp',
        ];
    }

}
