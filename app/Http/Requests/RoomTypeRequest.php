<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomTypeRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:50|unique:room_types,name',
            'slug' => 'required|string|max:50|unique:room_types,slug',
            'intro_description' => 'nullable|string',
            'main_image' => 'required|string',
            'thumbnails' => 'required|json',
            'amenities' => 'nullable|json',
            'max_people' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'area' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 50 ký tự.',
            'name.unique' => 'Tên đã tồn tại.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.string' => 'Slug phải là chuỗi ký tự.',
            'slug.max' => 'Slug không được vượt quá 50 ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',
            'intro_description.string' => 'Mô tả ngắn phải là chuỗi ký tự.',
            'main_image.required' => 'Hình ảnh chính là bắt buộc.',
            'main_image.string' => 'Hình ảnh chính phải là chuỗi ký tự.',
            'thumbnails.required' => 'Thumbnails là bắt buộc.',
            'thumbnails.json' => 'Thumbnails phải là định dạng JSON.',
            'amenities.json' => 'Tiện nghi phải là định dạng JSON.',
            'max_people.required' => 'Số người tối đa là bắt buộc.',
            'max_people.integer' => 'Số người tối đa phải là số nguyên.',
            'max_people.min' => 'Số người tối đa phải lớn hơn hoặc bằng 1.',
            'price.required' => 'Giá là bắt buộc.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá phải lớn hơn hoặc bằng 0.',
            'area.required' => 'Diện tích là bắt buộc.',
            'area.integer' => 'Diện tích phải là số nguyên.',
            'area.min' => 'Diện tích phải lớn hơn hoặc bằng 1.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
        ];
    }
}
