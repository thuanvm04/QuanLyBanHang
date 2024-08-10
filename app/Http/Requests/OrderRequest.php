<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'ten_nguoi_dung' => 'required|max:255|string',
            'so_dien_thoai_nguoi_dung' => 'required|string|regex:/^0[0-9]{9,10}$/',
            'email_nguoi_nhan' => 'required|max:255|string',
            'dia_chi_nguoi_nhan' => 'required|max:255|string',


        ];
    }


    public function messages(){

        return [
            'ten_nguoi_dung.required' => 'Vui lòng nhập họ tên',
            'ten_nguoi_dung.max' => 'Họ tên tối đa 255 ký tự',
            'ten_nguoi_dung.string' => 'Họ tên phải là chuỗi ký tự',
            'so_dien_thoai_nguoi_dung.required' => 'Vui lòng nhập số điện thoại',
            'so_dien_thoai_nguoi_dung.string' => 'Số điện thoại phải là chuỗi ký tư',
            'so_dien_thoai_nguoi_dung.regex' => 'Số điện thoại phải bắt đầu bằng 0',
            'so_dien_thoai_nguoi_dung.min' => 'Số điện thoại phải có nhiều hơn 10 số',
            'email_nguoi_nhan.required' => 'Vui lòng nhập email',
            'email_nguoi_nhan.max' => 'Email tối đa 255 ký tự',
            'email_nguoi_nhan.string' => 'Email phải là chuỗi ký tự',
            'dia_chi_nguoi_nhan.required' => 'Vui lòng nhập địa chỉ',
            'dia_chi_nguoi_nhan.max' => 'Địa chỉ tối đa 255 ký tự',
            'dia_chi_nguoi_nhan.string' => 'Địa chỉ phải là chuỗi ký tự',


        ];
    }
}
