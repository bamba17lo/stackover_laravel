<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            // 'role' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            
            'password' => 'required|string|min:8',
        ];
    }

    public function failedvalidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'=>false,
            'status_code'=>422,
            'error'=>true,
            'message'=>'Erreur de validation',
            'errorsList'=>$validator->errors()

        ]));
    }

    Public function messages()
    {
        return[
            'nom.required'=>'Un nom doit etre fourni',
            'prenom.required'=>'Un prenom doit etre fourni',
            'email.required'=>'Une adresse mail doit etre fourni',
            'email.unique'=>'Cette adresse mail existe déja',
            'password.required'=>'Un mot de pass doit etre fourni',
        ];
    }
}
