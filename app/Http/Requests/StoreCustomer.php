<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomer extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'given_name' => ['required', 'string', 'alpha'],
            'family_name' => ['required', 'string', 'alpha'],
            'email' => ['required', 'email', 'unique:customers'],
            'company_id' => ['required', 'integer', 'exists:companies,id']
        ];
    }
}
