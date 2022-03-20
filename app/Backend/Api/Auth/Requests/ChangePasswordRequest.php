<?php

namespace App\Backend\Api\Auth\Requests;

use App\Support\Auth\Contracts\Documentation\ChangePasswordRequest as Documentation;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest implements Documentation
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
            'password' => 'required|min:8|confirmed',
        ];
    }
}
