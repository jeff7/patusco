<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            //
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'user_type' => 'required|in:D,R'
        ];
    }

   public function messages(){
        return [
            'required' => 'Campo é obrigatorio',
            'user_type.in' => 'O tipo de usuário é Inválido.',
            'name.min' => 'Nome invalido',
            'password.min' => 'Password Invalido',
            'email.email' => 'Email Invalido',
        ];
    }
}
