<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'username'=>'required',
            'password'=>'required',
            'id_admin_type'=>'required',
        ];

    }
    public function getACredentials(){
        $credentials = $this->all();

    return [
        'username' => $credentials['username'],
        'password' => $credentials['password'],

    ];
    }
    public function messages(): array
    {
        return [
            'username.required' => 'El campo de nombre de usuario es obligatorio.',
            'password.required' => 'El campo de contraseña es obligatorio.',
            'id_admin_type.required' => 'El campo de tipo de administrador es obligatorio.',
        ];
    }



}
