<?php

namespace App\Backend\Api\User\Request;

use App\Domain\User\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->count() > 0;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = User::byUuid($this->route('user'))->first();
        $userId = $user ? $user->id : 0;

        return [
            'name' => 'sometimes|required|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $userId,
        ];
    }
}
