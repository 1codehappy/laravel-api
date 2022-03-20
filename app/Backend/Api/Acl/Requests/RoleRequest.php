<?php

namespace App\Backend\Api\Acl\Requests;

use App\Support\Acl\Contracts\Documentation\RoleRequest as Documentation;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest implements Documentation
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

        return [
            'name' => "{$required}|max:255",
            'permissions' => 'sometimes|nullable|array',
            'permissions.*' => 'sometimes|nullable|exists:permissions,name',
        ];
    }
}
