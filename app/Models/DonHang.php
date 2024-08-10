<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;

    const TRANG_THAI_DON_HANG = [
        'cho_xac_nhan' => 'Chờ xác nhận',
        'da_xac_nhan' => 'Đã xác nhận',
        'dang_chuan_bi' => 'Đang chuẩn bị',
        'dang_van_chuyen' => 'Đang vận chuyển',
        'da_giao_hang' => 'Đã giao hàng',
        'huy_don_hang' => 'Đã hủy đơn hàng',

    ];

    const TRANG_THAI_THANH_TOAN = [
        'chua_thanh_toan' => 'Chưa thanh toán',
        'da_thanh_toan' => 'Đã thanh toán',
        

    ];
    const CHO_XAC_NHAN = 'cho_xac_nhan';
    const DA_XAC_NHAN = 'da_xac_nhan';
    const DANG_CHUAN_BI = 'dang_chuan_bi';
    const DANG_VAN_CHUYEN = 'dang_van_chuyen';
    const DA_GIAO_HANG = 'da_giao_hang';
    const HUY_DON_HANG = 'huy_don_hang';

    const CHUA_THANH_TOAN = 'chua_thanh_toan';
    const DA_THANH_TOAN = 'da_thanh_toan';



    protected $fillable = [
        'ma_don_hang',
        'user_id',
        'ten_nguoi_nhan',
        'email_nguoi_nhan',
        'so_dien_thoai_nguoi_nhan',
        'dia_chi_nguoi_nhan',
        'ghi_chu',
        'trang_thai_don_hang',
        'trang_thai_thanh_toan',
        'tong_tien',
        'tien_ship',
        'tien_hang',
        
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chiTietDonHang()
    {
        return $this->hasMany(ChiTietDonHang::class);
    }
}
