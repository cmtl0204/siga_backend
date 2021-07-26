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

            'company.user.address.main_street' => [
                'required'
            ],
            'company.user.address.secondary_street' => [
                'required'
            ],
            'company.user.address.number' => [

            ],
            'company.user.address.post_code' => [

            ],
            'company.user.address.reference' => [

            ],
            'company.user.address.longitude' => [

            ],
            'company.user.address.latitude' => [

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
            'company.prefix' => [
                'required',
                'min:2',
                'max:5',
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

            'company.user.address.main_street'=>'calle principal',
            'company.user.address.secondary_street'=>'calle secundaria',
            'company.user.identification_type.id'=>'tipo de identificacion-ID',
            'company.user.identification'=>'identificacion',
            'company.user.email'=>'email',
            'company.user.phone'=>'telefono',
            'company.trade_name' => 'nombre comercial',
            'company.comercial_activities' => 'actividad comercial',
            'company.web' => 'web',
            'company.prefix'=>'prefijo',
            'company.type.id' => 'tipo-ID',
            'company.activity_type.id' => 'tipo de actividad-ID',
            'company.person_type.id' => 'tipo de persona-ID',

        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
