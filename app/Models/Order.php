<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function orderDetails()
    // Method untuk ambil semua rincian (detail) dari pesanan ini
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
        // artimya: 1 Order PUNYA BANYAK OrderDetail
        // OrderDetail::class → model tujuan relasi
        // 'order_id' → kolom penghubung di tabel order_details
        // (kolom ini menyimpan ID pesanan induknya)
    }
}
