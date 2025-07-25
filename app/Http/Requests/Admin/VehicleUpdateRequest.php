<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VehicleUpdateRequest extends VehicleStoreRequest
{
   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {   

        return [
            'name'=> 'min:3|max:255|required'.$this->route('id'),
            'brand'=> 'min:3|max:255|required',
            'price_per_day'=>'min:3|max:255|required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'=> 'required',
            'category_id'=>'required'
        ];
    }

}

