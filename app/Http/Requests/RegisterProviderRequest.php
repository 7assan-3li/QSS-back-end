<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterProviderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Anyone can register
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required|string|max:150',
            'requestContent' => 'required|string|max:2000',
            'id_card' => 'required|image|mimes:jpg,jpeg,png|max:10240',
            'fcm_token' => 'nullable|string',
            'device_token' => 'nullable|string',
        ];
    }
}
