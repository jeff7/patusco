<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            //
            'client_name' => 'required|min:3',
            'email' => 'required|email',
            'animal_name' => 'required|min:3',
            'animal_type' => 'required|in:C,D,F,B',
            'age' => 'required|min:0|numeric',
            'symptoms' => 'required|string|max:255',
            'appointment_date' => 'required',
            'period' => 'required|in:M,T',
            'user_id' => 'required|numeric',
        ];
    }

   public function messages(){
        return [
            'required' => 'Campo é obrigatorio',
        ];
    }
}
