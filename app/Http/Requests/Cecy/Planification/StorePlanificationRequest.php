<?php

namespace App\Http\Requests\Cecy\Planification;

use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StorePlanificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
          
          'planification.date_start' => [
              'required',
          ],
          'planification.date_end' => [
              'required',
          ],
          'planification.course_id' => [
              'required',
              'integer',
          ],
          'planification.needs' => [
              'required',
          ],
          'planification.teacher_responsable_id' => [
              'required',
              'integer',
          ],
          'planification.status.id' => [
              'required',
              'integer'
          ]
        ];
        return CecyFormRequest::rules($rules);
    }
    public function attributes()
    {
        $attributes = [
            'planification.date_start' => 'fecha inicio',
            'planification.date_end' => 'fecha fin',
            'planification.course_id' => 'course',
            'planification.teacher_responsable_id' => 'teacher',
            'planification.needs' => 'course',
            'panification.status.id'=> 'status',
        ];
        return CecyFormRequest::attributes($attributes);
    }
}
