<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfilePhoneRequest extends FormRequest
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
            "phone"=> "sometimes|string|max:255",
            "country_code"=> "sometimes|string|max:255",
            "type"=> "sometimes|string|in:mobile,landline,whatsapp",
            "is_primary"=> "sometimes|boolean",
            "is_active"=> "sometimes|boolean",
        ];
    }
}
