<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'room_number' => 'required|string|max:10|unique:rooms,room_number',
            'room_type_id' => 'required|exists:room_types,id',
            'status' => 'required|in:' . implode(',', \App\Enums\RoomStatus::getValues()),
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'room_number.required' => 'Số phòng là bắt buộc.',
            'room_number.string' => 'Số phòng phải là chuỗi ký tự.',
            'room_number.max' => 'Số phòng không được vượt quá 10 ký tự.',
            'room_number.unique' => 'Số phòng đã tồn tại.',
            'room_type_id.required' => 'Loại phòng là bắt buộc.',
            'room_type_id.exists' => 'Loại phòng không tồn tại.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
        ];
    }
}
