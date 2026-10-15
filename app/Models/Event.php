<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// Ambil trait HasFactory,  untuk bikin data dummy lewat factory 
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    // Pakai trait HasFactory supaya model ini bisa dipakai untuk testing / seeding

    protected $table = 'events';
    // Tentukan nama tabel di database: "events"
    // (kalau tidak ditulis, Laravel otomatis nebak jadi "events" dari nama class Event)
    protected $guarded = ['id'];
    // Kolom "id" TIDAK boleh diisi massal (dilindungi)
    // Kolom lain (name, category, price, description, image) BOLEH diisi massal
    // Ini kebalikan dari $fillable pakai $guarded biar lebih ringkas
}
