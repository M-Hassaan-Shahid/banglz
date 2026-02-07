<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePreferencesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'marketing_emails' => 'nullable|boolean',
            'order_updates' => 'nullable|boolean',
            'newsletter' => 'nullable|boolean',
            'product_recommendations' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'marketing_emails.boolean' => 'Marketing emails preference must be true or false.',
            'order_updates.boolean' => 'Order updates preference must be true or false.',
            'newsletter.boolean' => 'Newsletter preference must be true or false.',
            'product_recommendations.boolean' => 'Product recommendations preference must be true or false.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'marketing_emails' => 'marketing emails',
            'order_updates' => 'order updates',
            'newsletter' => 'newsletter',
            'product_recommendations' => 'product recommendations',
        ];
    }

    /**
     * Handle a failed validation attempt for AJAX requests.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        if ($this->wantsJson() || $this->ajax()) {
            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422)
            );
        }

        parent::failedValidation($validator);
    }
}
