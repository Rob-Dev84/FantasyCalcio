<?php

namespace App\Http\Requests\Team;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', //Unique team name per league 
                        Rule::unique('teams', 'name')->where('league_id', auth()->user()->userSetting->league_id),    
                        'min:3|max:25'],
            'stadium' => 'required|min:3|max:25'
        ];
    }
}
