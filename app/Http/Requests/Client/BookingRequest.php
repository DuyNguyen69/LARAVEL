<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|min:10|max:15',
            'customer_email' => 'required|email',
            'customer_id_number' => 'required|string|max:50',
            'delivery_option' => 'required|in:pickup_self,delivery_to_location',
            'delivery_address' => 'required_if:delivery_option,delivery_to_location|max:255',
            'pickup_date' => 'required|date|after_or_equal:today',
            'dropoff_date' => 'required|date|after:pickup_date',
            'pickup_time' => 'required|date_format:H:i',
            'dropoff_time' => 'required|date_format:H:i',
            'car_id' => 'required|exists:cars,id',
        ];
    }
    public function messages()
    {
        return [
            'car_id.required' => 'You must select a car.',
            'car_id.exists' => 'The selected car is invalid.',
            'delivery_address.required_if' => 'The delivery address is required when delivery option is selected.',
            'pickup_date.after_or_equal' => 'The pickup date must be today or a future date.',
            'dropoff_date.after' => 'The drop-off date must be after the pickup date.',
            'pickup_time.date_format' => 'Pickup time must be in HH:MM format.',
            'dropoff_time.date_format' => 'Drop-off time must be in HH:MM format.',
        ];
    }
}
