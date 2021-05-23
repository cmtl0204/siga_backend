<?php


namespace App\Http\Requests\JobBoard\Company;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        $rules = [
            'company.user.address.id' => [
                'required',
                'integer',
            ],
            'company.user.identificationType.id' => [
                'required',
                'integer',
            ],
            'company.user.username' => [
                'required',
                'min:10',
                'max:100',
            ],
            'company.user.identification' => [
                'required',
                'min:10',
                'max:15',
            ],
            'company.user.email' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'company.user.password' => [
                'required',
                'min:5',
                'max:15',
            ],

            'company.trade_name' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'company.comercial_activities' => [
                'required',
            ],
            'company.comercial_activities.*' => [
                'required',
                'max:1000',
                'min:10',

            ],
            'company.web' => [
                'required',
                'min:10',
                'max:1000',
            ],

            'company.type.id' => [
                'required',
                'integer',
            ],
            'company.activityType.id' => [
                'required',
                'integer',
            ],
            'company.personType.id' => [
                'required',
                'integer',
            ],


        ];
        return JobBoardFormRequest::rules($rules);
    }
    public function messages()
    {
        $messages = [
            'company.user.address.id.integer'=>'El campo :attribute debe ser numérico',
            'company.user.identificationType.id.integer'=>'El campo :attribute debe ser numérico',
            'company.user.username.required'=>'El campo :attribute es obligatorio',
            'company.user.username.min'=>'El campo :attribute debe tener al menos :min caracteres',
            'company.user.username.max'=>'El campo :attribute debe tener al menos :max caracteres',
            'company.user.identification.required'=>'El campo :attribute es obligatorio',
            'company.user.identification.min'=>'El campo :attribute debe tener al menos :min caracteres',
            'company.user.identification.max'=>'El campo :attribute debe tener al menos :max caracteres',
            'company.user.email.required'=>'El campo :attribute es obligatorio',
            'company.user.email.min'=>'El campo :attribute debe tener al menos :min caracteres',
            'company.user.email.max'=>'El campo :attribute debe tener al menos :max caracteres',
            'company.user.password.required'=>'El campo :attribute es obligatorio',
            'company.user.password.min'=>'El campo :attribute debe tener al menos :min caracteres',
            'company.user.password.max'=>'El campo :attribute debe tener al menos :max caracteres',
            'company.trade_name.required' => 'El campo :attribute es obligatorio',
            'company.trade_name.min' => 'El campo :attribute debe tener al menos :min caracteres',
            'company.comercial_activities.required' => 'El campo :attribute es obligatorio',
            'company.comercial_activities.*.min'=>'El campo:attribute debe tener al menos :min caracteres',
            'company.comercial_activities.*.max'=>'El campo:attribute debe tener máximo :max caracteres',
            'company.web.required' => 'El campo :attribute es obligatorio',
            'company.web.min' => 'El campo : attribute debe tener al menos :min carecteres',
            'company.type.id.integer' => 'El campo :attribute debe ser numérico',
            'company.activityType.id.integer' => 'El campo :attribute debe ser numérico',
            'company.personType.id.integer' => 'El campo :attribute debe ser numérico',


        ];
        return JobBoardFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'company.user.address.id'=>'direccion-ID',
            'company.user.identificationType.id'=>'tipo de identificacion-ID',
            'company.user.username'=>'nombre de usuario',
            'company.user.identification'=>'identificacion',
            'company.user.email'=>'email',
            'company.user.password'=>'password',
            'company.trade_name' => 'nombre comercial',
            'company.comercial_activities' => 'actividad comercial',
            'company.web' => 'web',
            'company.type.id' => 'tipo-ID',
            'company.activityType.id' => 'tipo de actividad-ID',
            'company.personType.id' => 'tipo de persona-ID',

        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
