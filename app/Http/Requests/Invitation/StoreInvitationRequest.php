<?php

namespace App\Http\Requests\Invitation;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvitationRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255',
                        Rule::unique('users')->where('email', $this->input('email')),//if league admin invites themself
                        Rule::unique('invitations')->where('email', $this->input('email'))
                                                    ->where('league_id', $this->league->id),//if user has already bein invited
                        ],
        ];
    }
}
