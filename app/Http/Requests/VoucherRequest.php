<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:vouchers,name',
            'main_image' => 'nullable|string',
            'description' => 'nullable|string',
            'code' => 'required|string|max:20|unique:vouchers,code',
            'discount_amount' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên voucher là bắt buộc.',
            'name.string' => 'Tên voucher phải là chuỗi ký tự.',
            'name.max' => 'Tên voucher không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên voucher đã tồn tại.',
            'main_image.string' => 'Ảnh đại diện phải là chuỗi ký tự.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
            'code.required' => 'Mã voucher là bắt buộc.',
            'code.string' => 'Mã voucher phải là chuỗi ký tự.',
            'code.max' => 'Mã voucher không được vượt quá 20 ký tự.',
            'code.unique' => 'Mã voucher đã tồn tại.',
            'discount_amount.required' => 'Số tiền giảm giá là bắt buộc.',
            'discount_amount.numeric' => 'Số tiền giảm giá phải là số.',
            'discount_amount.min' => 'Số tiền giảm giá phải lớn hơn hoặc bằng 0.',
            'valid_from.required' => 'Ngày bắt đầu hiệu lực là bắt buộc.',
            'valid_from.date' => 'Ngày bắt đầu hiệu lực phải là ngày hợp lệ.',
            'valid_until.required' => 'Ngày hết hạn là bắt buộc.',
            'valid_until.date' => 'Ngày hết hạn phải là ngày hợp lệ.',
            'valid_until.after_or_equal' => 'Ngày hết hạn phải sau hoặc bằng ngày bắt đầu hiệu lực.',
        ];
    }
}
