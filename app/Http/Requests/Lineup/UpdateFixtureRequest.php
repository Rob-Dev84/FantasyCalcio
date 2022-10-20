<?php

namespace App\Http\Requests\Lineup;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFixtureRequest extends FormRequest
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
            // 'fixture' => ['required', 
            //                 Rule::exists('lineups', 'fixture_id')->where('team_id', auth()->user()->team->id),    
            //     'integer'],
        ];
    }
}
