<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'san_pham';
    public $timestamps = false;
    protected $fillable = [
        'tieu_de',
        'ten',
        'gia',
        'hinh_anh',
        'id_danh_muc',
        'bao_hanh',
        'series_model',
        'mau_sac',
        'nhu_cau',
        'cpu',
        'chip_do_hoa',
        'man_hinh',
        'webcam',
        'ram',
        'luu_tru',
        'cong_ket_noi',
        'ket_noi_khong_day',
        'ban_phim',
        'he_dieu_hanh',
        'pin',
        'khoi_luong',
        'bao_mat',
        'status'
    ];

    // Scope để lấy chỉ sản phẩm đang hoạt động
    public function scopeActive($query)
    {
        return $query->whereRaw('COALESCE(status, 1) = 1');
    }

    // Scope để lấy sản phẩm đã xóa
    public function scopeTrashed($query)
    {
        return $query->where('status', 0);
    }

    // Quan hệ với danh mục
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_danh_muc', 'id');
    }
}
