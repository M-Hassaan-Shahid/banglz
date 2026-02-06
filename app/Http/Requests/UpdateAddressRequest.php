<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if user owns the address being updated
        $address = $this->route('address');
        return auth()->check() && $address && $address->user_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'recipient_name' => 'required|string|max:255',
            'street_address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
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
            'recipient_name.required' => 'Please enter the recipient name.',
            'recipient_name.max' => 'Recipient name cannot exceed 255 characters.',
            'street_address.required' => 'Please enter the street address.',
            'street_address.max' => 'Street address cannot exceed 500 characters.',
            'city.required' => 'Please enter the city.',
            'city.max' => 'City name cannot exceed 255 characters.',
            'state.required' => 'Please enter the state or province.',
            'state.max' => 'State name cannot exceed 255 characters.',
            'postal_code.required' => 'Please enter the postal code.',
            'postal_code.max' => 'Postal code cannot exceed 20 characters.',
            'country.required' => 'Please enter the country.',
            'country.max' => 'Country name cannot exceed 255 characters.',
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
            'recipient_name' => 'recipient name',
            'street_address' => 'street address',
            'postal_code' => 'postal code',
        ];
    }

    /**
     * Handle a failed authorization attempt.
     */
    protected function failedAuthorization()
    {
        throw new \Illuminate\Auth\Access\AuthorizationException(
            'You are not authorized to update this address.'
        );
    }
}
