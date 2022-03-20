<?php

namespace App\Backend\Api\Auth\Requests;

use App\Support\Auth\Contracts\Documentation\EditProfileRequest as Documentation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditProfileRequest extends FormRequest implements Documentation
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->request->count() > 0;
    }

    /**
     * Apply rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . Auth::id(),
        ];
    }
}
