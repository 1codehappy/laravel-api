<?php

namespace App\Backend\Api\User\Requests;

use App\Domain\User\Models\User;
use App\Support\User\Contracts\Documentation\UserRequest as Documentation;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest implements Documentation
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $required = request()->isMethod('post') ? 'required' : 'sometimes';

        $rules = [
            'name' => "{$required}|max:255",
            'email' => "{$required}|email|unique:users,email",
            'roles' => 'sometimes|nullable|array',
            'roles.*' => 'sometimes|nullable|exists:roles,name',
            'permissions' => 'sometimes|nullable|array',
            'permissions.*' => 'sometimes|nullable|exists:permissions,name',
        ];

        if ($required === 'required') {
            $rules['password'] = 'sometimes|min:8|confirmed';
        }

        if (request()->isMethod('put')) {
            $user = User::byUuid($this->route('user'))->first();
            $userId = $user ? $user->id : 0;
            $rules['email'] .= ',' . $userId;
        }

        return $rules;
    }
}
