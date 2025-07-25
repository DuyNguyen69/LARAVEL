<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VehicleStoreRequest extends FormRequest
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
            'name'=> 'min:3|max:255|required',
            'brand'=> 'min:3|max:255|required',
            'price_per_day'=>'min:3|max:255|required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'=> 'required',
            'category_id'=>'required'
        ];
    }
    public function messages()
    {
        return [
        //     'name.required' => 'Vui lòng nhập tên xe.',
        // 'name.min' => 'Tên xe phải có ít nhất 3 ký tự.',
        // 'name.max' => 'Tên xe không được vượt quá 255 ký tự.',

        // 'brand.required' => 'Vui lòng nhập hãng xe.',
        // 'brand.min' => 'Hãng xe ít nhất 3 ký tự.',
        // 'brand.max' => 'Hãng xe không quá 255 ký tự.',

        // 'price_per_day.required' => 'Vui lòng nhập giá thuê.',
        // 'description.required' => 'Vui lòng nhập mô tả.',
        // 'image.required' => 'Bạn cần chọn hình ảnh xe.',
        // 'status.required' => 'Vui lòng chọn trạng thái.',
        // 'category_id.required' => 'Vui lòng chọn dòng xe.',
        ];
    }
}
