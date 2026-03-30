<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserVerificationPackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'verification_package_id' => 'required|exists:verification_packages,id',
            'image_bond'              => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'number_bond'             => 'required|string|max:255',
        ];
    }
}
