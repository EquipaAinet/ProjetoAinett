<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPost extends FormRequest
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
            'name' =>                'required|string|max:255',
            'email' => [
                'required','email',
                Rule::unique('users')->ignore($user->id),
            ],
            'NIF' => 'nullable|digits:9',
            'telefone' => 'nullable|max:12|min:9',
            'foto' =>'nullable|image|max:8192',
        ];
    }

}
