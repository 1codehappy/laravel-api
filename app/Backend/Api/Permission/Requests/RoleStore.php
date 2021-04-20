<?php

namespace App\Backend\Api\Permission\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleStore extends FormRequest
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
        return [
            'name' => 'required|max:255',
            'permissions' => 'sometimes|array',
        ];
    }
}
