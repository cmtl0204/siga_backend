<?php


namespace App\Http\Requests\JobBoard\Company;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateCompanyRequest extends FormRequest
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
//                'required',
//                'json',
            ],
            'company.web' => [
                'required',
                'min:10',
                'max:1000',
            ],
//            'offer.id' => [
//                'required',
//                'integer',
//            ],
//            'user.id' => [
//                'required',
//                'integer',
//            ],
            'type.id' => [
                'required',
                'integer',
            ],
            'activityType.id' => [
                'required',
                'integer',
            ],
            'personType.id' => [
                'required',
                'integer',
            ],
            'professional.id' => [
//                'required',
//                'integer',
            ],


        ];
        return JobBoardFormRequest::rules($rules);
    }
    public function messages()
    {
        $messages = [
            'company.trade_name.required' => 'El campo :attribute es obligatorio',
            'company.trade_name.min' => 'El campo :attribute debe tener al menos :min caracteres',
//            'company.comercial_activity.required' => 'El campo :attribute es obligatorio',
            'company.web.required' => 'El campo :attribute es obligatorio',
            'company.web.min' => 'El campo : attribute debe tener al menos :min carecteres',
//            'offer.id.integer' => 'El campo :attribute debe ser numérico',
//            'user.id.integer' => 'El campo :attribute debe ser numérico',
            'type.id.integer' => 'El campo :attribute debe ser numérico',
            'activityType.id.integer' => 'El campo :attribute debe ser numérico',
            'personType.id.integer' => 'El campo :attribute debe ser numérico',
    //        'professional.id.integer' => 'El campo :attribute debe ser numérico',
        ];
        return JobBoardFormRequest::messages($messages);
    }

    public function attributes()
    {
        $attributes = [
            'company.trade_name' => 'nombre comercial',
            'company.comercial_activities' => 'actividad comercial',
            'company.web' => 'web',
//            'offer.id' => 'oferta-ID',
//            'user.id' => 'usuario-ID',
            'type.id' => 'tipo-ID',
            'activityType.id' => 'tipo de actividad-ID',
            'personType.id' => 'tipo de persona-ID',
        //    'professional.id' => 'profesion-ID',
        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
