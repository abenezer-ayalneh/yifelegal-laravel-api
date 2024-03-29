<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(["phone_number" => "string"])] public function rules()
    {
        return [
            "phone_number" => "required|string",
        ];
    }

    /**
     * Prepare the request attributes for validation
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            "phone_number" => $this->phoneNumber,
        ]);
    }
}
