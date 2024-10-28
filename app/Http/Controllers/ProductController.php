<?php
// Tag pembuka PHP yang menandakan bahwa kode berikutnya adalah kode PHP
namespace App\Http\Controllers; // Menetapkan namespace 'App\Http\Controllers' untuk controller ini, yang mengelompokkan kelas dalam proyek Laravel

use App\Models\Product; // Mengimpor model 'Product' agar bisa digunakan di dalam 'ProductController' untuk mengakses data produk dari database
use Illuminate\View\View; // Mengimpor kelas View dari namespace Illuminate\View

class ProductController extends Controller // Mendefinisikan kelas 'ProductController' yang merupakan turunan dari kelas 'Controller'
{
    /**
     * index
     *
     * @return void
     */
    public function index() : View // Mendeklarasikan metode 'index' dengan visibilitas 'public', yang akan mengembalikan objek tipe 'View'
    {
        // Mengambil semua data produk dari database, diurutkan berdasarkan produk terbaru, dengan 10 produk per halaman
        $products = Product::latest()->paginate(10);

        // Me-render tampilan 'products.index' dan mengirimkan variabel 'products' ke dalamnya untuk digunakan di dalam template
        return view('products.index', compact('products'));
    }
}
