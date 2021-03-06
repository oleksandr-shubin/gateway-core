<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomer extends FormRequest
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
            'email' => [
                'required', 'email',
                Rule::unique('customers')
                    ->where(function ($query) {
                        $query->where('deleted_at', null);
                    })
                    ->ignore(request('customer')->id)

            ],
        ];
    }
}
