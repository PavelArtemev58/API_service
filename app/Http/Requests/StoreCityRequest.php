<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Country;

class StoreCityRequest extends FormRequest
{
    /**
    * Остановить валидацию после первой неуспешной проверки.
    *
    * @var bool
    */
    protected $stopOnFirstFailure = true;
    
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $countries = Country::get('name');
        $rule = [];
        foreach ($countries as $country){
            $rule[] = $country->name;
        }
        
        return [
            'name' => ['bail', 'required', 'unique:cities'],
            'country' => ['bail', 'required',
                Rule::in($rule)
                ]
        ];
    }
}
