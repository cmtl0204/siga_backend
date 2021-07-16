<?php

namespace App\Http\Requests\Cecy\Course;

use App\Http\Requests\Cecy\CecyFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class IndexCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = [

            // 'id' => [
            //     'required',
            // ],
            // 'code' => [
            //     'required'
            // ],
            // 'abbreviation'=> [
            //     'required'
            // ],
            // 'name'=> [
            //     'required'
            // ],
            // 'duration'=> [
            //     'required'
            // ],
            // 'institution_id'=> [
            //     'required'
            // ],
            // 'anc_id'=> [
            //     'required'
            // ],
            // 'type_id'=> [
            //     'required'
            // ],
            // 'modality_id'=> [
            //     'required'
            // ],
            // 'summary'=> [
            //     'required'
            // ],
            // 'project'=> [
            //     'required'
            // ],
            // 'target_groups'=> [
            //     'required'
            // ],
            // 'participant_type'=> [
            //     'required'
            // ],
            // 'specialty_id'=> [
            //     'required'
            // ],
            // 'technical_requirements'=> [
            //     'required'
            // ],
            // 'general_requirements'=> [
            //     'required'
            // ],
            // 'objective'=> [
            //     'required'
            // ],
            // 'cross_cutting_topics'=> [
            //     'required'
            // ],
            // 'teaching_strategies'=> [
            //     'required'
            // ],
            // 'bibliographies'=> [
            //     'required'
            // ],
            // 'free'=> [
            //     'required'
            // ],
            // 'cost'=> [
            //     'required'
            // ],
            // 'observations'=> [
            //     'required'
            // ],
            // 'capacitation_type_id'=> [
            //     'required'
            // ],
            // 'entity_certification_type_id'=> [
            //     'required'
            // ],
            // 'certified_type_id'=> [
            //     'required'
            // ]
           
          
        ];

        return CecyFormRequest::rules($rules);
    }

    public function attributes(){
        
        $attributes = [
            'id' => 'id',
            
        ];

        return CecyFormRequest::rules($attributes);
    }   
}
