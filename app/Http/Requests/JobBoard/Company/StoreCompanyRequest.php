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

            'company.trade_name' => [
                'required',
                'min:10',
                'max:1000',
            ],
            'company.comercial_activities' => [
                'required',
//                'json',
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
            'company.trade_name.required' => 'El campo :attribute es obligatorio',
            'company.trade_name.min' => 'El campo :attribute debe tener al menos :min caracteres',
            'company.comercial_activity.required' => 'El campo :attribute es obligatorio',
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
