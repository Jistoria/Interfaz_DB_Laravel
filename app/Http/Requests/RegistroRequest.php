<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\RFCValidation;

class RegistroRequest extends FormRequest
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
        $emailValidator = new EmailValidator();
        return [
            'name' => 'required|max:18',
            'lastname' => 'required|max:18',
            'email' => [
                'required',
                'unique:users,email',
                function ($attribute, $value, $fail) use ($emailValidator) {
                    if (!$emailValidator->isValid($value, new RFCValidation())) {
                        $fail('El correo electrónico no es válido.');
                    }
                },
            ],
            'phone' => [
                'required',
                function ($attribute, $value, $fail) {
                    $phoneUtil = PhoneNumberUtil::getInstance();
                    try {
                        $phoneNumber = $phoneUtil->parse($value, 'EC');
                        if (!$phoneUtil->isValidNumber($phoneNumber)) {
                            $fail('El número de teléfono no es válido.');
                        }
                    } catch (NumberParseException $e) {
                        $fail('El número de teléfono no es válido.');
                    }
                },
            ],
            'phone2'=>'nullable',
            'address' => 'required',
            'password' => 'required|min:8',
        ];
    }
    public function messages()
    {
       return [
         'name.required' => ' El campo de Nombre debe estar lleno',
         'name.max' =>'Nombre muy extenso los caracteres pasan de :max caracteres.',
         'lastname.required'=>'El apellido es requerido',
         'lastname.max'=>'no exageres nadie tiene un apellido tan largo, o si?',
         'phone.required'=>'Es necesario el num.celular',
         'email.required' => 'El campo de email debe estar lleno',
         'email.unique' => 'El email ya esta en uso',
         'email.email' => 'El email no es valido',
         'address.required'=>'Necesitamos una direccion, para los envios',
         'password.required' => 'El campo de contraseña debe estar lleno',
         'password.min' => 'La contraseña es muy corta, los caracteres deben ser de al menos :min caracteres',
       ];
    }
}
