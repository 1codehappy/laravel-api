<?php

namespace App\Backend\Api\Permission\Requests;

use App\Domain\Permission\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->request->count() === 0) {
            return false;
        }

        if (request()->isMethod('put')) {
            return $this->user()->can('update', Role::class);
        }

        return $this->user()->can('create', Role::class);
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
