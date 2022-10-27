<?php

namespace App\Http\Requests\Team;

use App\Models\Team;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return true;
        return auth()->user()->id === $this->team->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
    
        return [
            'name' => ['required', //Ignore unique team name when user update name and Keep Unique team name per league 
                        Rule::unique('teams', 'name')->ignore($this->team->id)
                                             ->where('user_id', $this->team->user_id)
                                             ->where('league_id', $this->team->league_id),    
                        'min:3|max:25'
                    ],
            'stadium' => 'required|min:3|max:25'
        ];
    }
}
