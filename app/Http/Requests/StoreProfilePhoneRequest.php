<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfilePhoneRequest extends FormRequest
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
            "phone"=> "required|string|max:255",
            "country_code"=> "required|string|max:255",
            "profile_id"=> "required|exists:profiles,id",
            "type"=> "required|string|in:mobile,landline,whatsapp",
            "is_primary"=> "required|boolean",
            "is_active"=> "required|boolean",
        ];
    }
}
