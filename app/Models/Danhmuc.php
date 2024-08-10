<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Danhmuc extends Model
{
    protected $table = 'danh_mucs';
    use HasFactory;
    protected $fillable = [
        'hinh_anh',
        'ten_danh_muc',
        'trang_thai'
    ];
    protected $casts = [
        'trang_thai' => 'boolean',
    ];
    public function sanPham(){
        return $this->hasMany(SanPham::class);
    }
}
