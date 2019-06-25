<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProjectInvitationRequest extends FormRequest
{
    protected $errorBag = 'invitations';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('manage', $this->route('project'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', Rule::exists('users', 'email')]
        ];
    }

    public function messages()
    {
        // messages for specific cases - star for everything or names
        return [
            'email.*' => 'The user you are inviting must have an active rezno[R]ganizer account.'
        ];
    }
}
