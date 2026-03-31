<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestCommissionBondRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'request_id'   => 'required|exists:requests,id',
            'image'        => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'amount'       => 'required|numeric|min:0.01',
            'bond_number'  => 'nullable|integer',
            'description'  => 'nullable|string',
        ];


    }
}