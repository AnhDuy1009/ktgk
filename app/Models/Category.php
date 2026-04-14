<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'danh_muc_laptop';
    protected $fillable = ['ten_danh_muc'];
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class, 'id_danh_muc', 'id');
    }
}
