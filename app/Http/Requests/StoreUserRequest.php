<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class StoreUserRequest extends FormRequest
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
    #[ArrayShape(["name" => "string", "phone_number" => "string", "email" => "string"])] public function rules(): array
    {
        return [
            "name" => "required|string",
            "phone_number" => "required|string",
            "email" => "nullable|email",
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
