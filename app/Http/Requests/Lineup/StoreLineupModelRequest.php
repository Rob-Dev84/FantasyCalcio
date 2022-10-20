<?php

namespace App\Http\Requests\Lineup;

use Illuminate\Foundation\Http\FormRequest;

class StoreLineupModelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()//Since we don't use route model binding for this action, autorize is not required
    {
        return true;
        //return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'module_type_id' => 'required|integer|between:1,11',
        ];
    }
}
