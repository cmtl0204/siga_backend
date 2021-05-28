<?php


namespace App\Http\Requests\JobBoard\Company;

use App\Http\Requests\JobBoard\JobBoardFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'company.user.identification_type.id' => [
                'required',
                'integer',
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
            'company.user.phone' => [
                'required',
                'min:10',
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
            'company.activity_type.id' => [
                'required',
                'integer',
            ],
            'company.person_type.id' => [
                'required',
                'integer',
            ],

        ];
        return JobBoardFormRequest::rules($rules);
    }

    public function attributes()
    {
        $attributes = [
            'company.user.address.id'=>'direccion-ID',
            'company.user.identification_type.id'=>'tipo de identificacion-ID',
            'company.user.identification'=>'identificacion',
            'company.user.email'=>'email',
            'company.user.phone'=>'telefono',
            'company.trade_name' => 'nombre comercial',
            'company.comercial_activities' => 'actividad comercial',
            'company.web' => 'web',
            'company.type.id' => 'tipo-ID',
            'company.activity_type.id' => 'tipo de actividad-ID',
            'company.person_type.id' => 'tipo de persona-ID',

        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
