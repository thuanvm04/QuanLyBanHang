<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SanPhamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'ma_san_pham' => 'required|max:10|unique:san_phams,ma_san_pham,' . $this->route('id'),
            'ten_san_pham' => 'required|max:255',
            'hinh_anh' => 'image|mimes:jpg,png,jpeg,gif,svg,webp',
            'gia_san_pham' => 'required|numeric|min:0',
            'gia_khuyen_mai' => 'min:0|lte:gia_san_pham',
            'mo_ta_ngan' => 'string|max:255',
            'noi_dung' => 'nullable|string',
            'so_luong' => 'integer|min:0',
            'ngay_nhap' => 'required|date',
            'danhmuc_id' => 'required|exists:danh_mucs,id',
            
        ];
    }

    public function messages(): array
    {
        return [
            'ma_san_pham.required' => 'Vui lòng nhập mã sản phẩm.',
            'ma_san_pham.max' => 'Mã sản phẩm tối đa 10 ký tự.',
            'ma_san_pham.unique' => 'Mã sản phẩm đã tồn tại.',
            
            'ten_san_pham.required' => 'Vui lòng nhập tên sản phẩm.',
            'ten_san_pham.max' => 'Tên sản phẩm tối đa 255 ký tự.',
            
            'hinh_anh.image' => 'Hình ảnh phải là tệp ảnh.',
            'hinh_anh.mimes' => 'Hình ảnh phải có định dạng .jpg, .png, .jpeg, .gif, hoặc .svg.',
           
            
            'gia_san_pham.required' => 'Vui lòng nhập giá sản phẩm.',
            'gia_san_pham.numeric' => 'Giá sản phẩm phải là số.',
            'gia_san_pham.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
            
        
            'gia_khuyen_mai.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0.',
            'gia_khuyen_mai.lte' => 'Giá khuyến mãi không thể lớn hơn giá sản phẩm.',
            
            'mo_ta_ngan.string' => 'Mô tả ngắn phải là chuỗi.',
            'mo_ta_ngan.max' => 'Mô tả ngắn tối đa 255 ký tự.',

            'noi_dung.string' => 'Nội dung phải là chuỗi.',

            
            'so_luong.integer' => 'Số lượng phải là số nguyên.',
            'so_luong.min' => 'Số lượng phải lớn hơn hoặc bằng 0.',
            
            'ngay_nhap.required' => 'Vui lòng nhập ngày nhập.',
            'ngay_nhap.date' => 'Ngày nhập phải là một ngày hợp lệ.',
            
            'danhmuc_id.required' => 'Vui lòng chọn danh mục.',
            'danhmuc_id.exists' => 'Danh mục không tồn tại.',
           
        ];
    }
}
