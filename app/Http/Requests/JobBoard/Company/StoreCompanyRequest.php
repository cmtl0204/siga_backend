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

            'company.user.address.main_street' => [
                'required',
                'max:1000',
            ],
            'company.user.address.secondary_street' => [
                'required',
                'max:1000',
            ],
            'company.user.identification_type.id' => [
                'required',
                'integer',
            ],
            'company.user.username' => [
                'required',
                'min:10',
                'max:13',
            ],
            'company.user.phone' => [
                'required',
                'min:7',
                'max:15',
            ],
            'company.user.cellphone' => [
                'required',
                'min:10',
                'max:15',
            ],
            'company.user.identification' => [
                'required',
                'min:10',
                'max:13',
            ],
            'company.user.email' => [
                'required',
                'max:320',
            ],
            'company.user.password' => [
                'required',
                'min:6',
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
                'min:10',
                'max:1000',
            ],
            'company.web' => [
                'required',
                'min:3',
                'max:100',
            ],
            'company.prefix' => [
                'required',
                'min:3',
                'max:5',
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
            'company.user.identification_type.id'=>'tipo de documento',
            'company.user.username'=>'nombre de usuario',
            'company.user.identification'=>'número de documento',
            'company.user.email'=>'email',
            'company.user.password'=>'password',
            'company.trade_name' => 'nombre comercial',
            'company.prefix'=>'prefijo',
            'company.comercial_activities' => 'actividades comerciales',
            'company.web' => 'página web',
            'company.type.id' => 'tipo',
            'company.activity_type.id' => 'tipo de actividad',
            'company.person_type.id' => 'tipo de empresa',

        ];
        return JobBoardFormRequest::attributes($attributes);
    }
}
