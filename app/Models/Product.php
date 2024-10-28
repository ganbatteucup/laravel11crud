<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory; // Mengimpor trait HasFactory untuk mendukung factory pada model ini

    // Menentukan atribut mana saja yang boleh diisi secara massal
    protected $fillable = [
        'image',        // Menyimpan URL atau path gambar item
        'title',        // Menyimpan judul atau nama item
        'description',  // Menyimpan deskripsi detail item
        'price',        // Menyimpan harga item
        'stock',        // Menyimpan jumlah stok item yang tersedia
    ];
    
}
