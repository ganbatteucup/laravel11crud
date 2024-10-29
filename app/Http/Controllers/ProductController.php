<?php

namespace App\Http\Controllers; // Mendefinisikan namespace untuk controller ini, yang membantu Laravel mengatur dan menemukan kelas.

use App\Models\Product; // Mengimpor model Product untuk digunakan dalam controller ini, memungkinkan kita untuk berinteraksi dengan tabel produk di database.

use Illuminate\View\View; // Mengimpor tipe data View untuk menandakan bahwa beberapa metode mengembalikan tampilan.

use Illuminate\Http\Request; // Mengimpor kelas Request dari HTTP untuk menangani data yang dikirim dari form.

use Illuminate\Http\RedirectResponse; // Mengimpor kelas RedirectResponse untuk mengembalikan respon redirect.

use Illuminate\Support\Facades\Storage; // Mengimpor facade Storage untuk mengelola penyimpanan file, seperti mengunggah dan menghapus gambar.

class ProductController extends Controller // Mendefinisikan kelas ProductController yang mewarisi dari Controller dasar Laravel.
{
    /**
     * index
     *
     * @return void
     */
    public function index() : View // Mendefinisikan metode index yang mengembalikan tampilan.
    {
        // Mendapatkan semua produk terbaru dengan paginasi 10 produk per halaman.
        $products = Product::latest()->paginate(10);

        // Mengembalikan tampilan 'products.index' dengan mengirimkan data produk.
        return view('products.index', compact('products'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View // Mendefinisikan metode create yang mengembalikan tampilan untuk membuat produk baru.
    {
        // Mengembalikan tampilan 'products.create' untuk menampilkan form pembuatan produk.
        return view('products.create');
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse // Mendefinisikan metode store untuk menyimpan produk baru.
    {
        // Memvalidasi data yang diterima dari form.
        $request->validate([
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048', // Validasi bahwa gambar harus diunggah dengan format tertentu.
            'title'         => 'required|min:5', // Validasi bahwa judul produk harus diisi dan minimal 5 karakter.
            'description'   => 'required|min:10', // Validasi bahwa deskripsi harus diisi dan minimal 10 karakter.
            'price'         => 'required|numeric', // Validasi bahwa harga harus diisi dan berupa angka.
            'stock'         => 'required|numeric' // Validasi bahwa stok harus diisi dan berupa angka.
        ]);

        // Mengunggah gambar yang diterima dari request.
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName()); // Menyimpan gambar dengan nama unik di direktori public/products.

        // Membuat produk baru menggunakan data dari request.
        Product::create([
            'image'         => $image->hashName(), // Menyimpan nama gambar yang diunggah.
            'title'         => $request->title, // Menyimpan judul produk.
            'description'   => $request->description, // Menyimpan deskripsi produk.
            'price'         => $request->price, // Menyimpan harga produk.
            'stock'         => $request->stock // Menyimpan stok produk.
        ]);

        // Mengalihkan ke halaman indeks produk dengan pesan sukses.
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    
    /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id): View // Mendefinisikan metode show untuk menampilkan detail produk berdasarkan ID.
    {
        // Mendapatkan produk berdasarkan ID. Jika tidak ditemukan, akan memunculkan error 404.
        $product = Product::findOrFail($id);

        // Mengembalikan tampilan 'products.show' dengan mengirimkan data produk.
        return view('products.show', compact('product'));
    }
    
    /**
     * edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id): View // Mendefinisikan metode edit untuk menampilkan form edit produk berdasarkan ID.
    {
        // Mendapatkan produk berdasarkan ID. Jika tidak ditemukan, akan memunculkan error 404.
        $product = Product::findOrFail($id);

        // Mengembalikan tampilan 'products.edit' dengan mengirimkan data produk.
        return view('products.edit', compact('product'));
    }
        
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse // Mendefinisikan metode update untuk memperbarui data produk.
    {
        // Memvalidasi data yang diterima dari form untuk memperbarui produk.
        $request->validate([
            'image'         => 'nullable|image|mimes:jpeg,jpg,png|max:2048', // Validasi bahwa gambar opsional dan jika ada harus sesuai format.
            'title'         => 'required|min:5', // Validasi bahwa judul harus diisi dan minimal 5 karakter.
            'description'   => 'required|min:10', // Validasi bahwa deskripsi harus diisi dan minimal 10 karakter.
            'price'         => 'required|numeric', // Validasi bahwa harga harus diisi dan berupa angka.
            'stock'         => 'required|numeric' // Validasi bahwa stok harus diisi dan berupa angka.
        ]);

        // Mendapatkan produk berdasarkan ID. Jika tidak ditemukan, akan memunculkan error 404.
        $product = Product::findOrFail($id);

        // Memeriksa apakah ada gambar yang diunggah.
        if ($request->hasFile('image')) {
            // Mengunggah gambar baru.
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName()); // Menyimpan gambar baru.

            // Menghapus gambar lama dari penyimpanan.
            Storage::delete('public/products/'.$product->image);

            // Memperbarui data produk dengan informasi baru.
            $product->update([
                'image'         => $image->hashName(), // Memperbarui nama gambar yang baru diunggah.
                'title'         => $request->title, // Memperbarui judul produk.
                'description'   => $request->description, // Memperbarui deskripsi produk.
                'price'         => $request->price, // Memperbarui harga produk.
                'stock'         => $request->stock // Memperbarui stok produk.
            ]);

        } else {
            // Jika tidak ada gambar yang diunggah, hanya memperbarui data lainnya.
            $product->update([
                'title'         => $request->title, // Memperbarui judul produk.
                'description'   => $request->description, // Memperbarui deskripsi produk.
                'price'         => $request->price, // Memperbarui harga produk.
                'stock'         => $request->stock // Memperbarui stok produk.
            ]);
        }

        // Mengalihkan ke halaman indeks produk dengan pesan sukses.
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse // Mendefinisikan metode destroy untuk menghapus produk berdasarkan ID.
    {
        // Mendapatkan produk berdasarkan ID. Jika tidak ditemukan, akan memunculkan error 404.
        $product = Product::findOrFail($id);

        // Menghapus gambar dari penyimpanan.
        Storage::delete('public/products/'. $product->image);

        // Menghapus produk dari database.
        $product->delete();

        // Mengalihkan ke halaman indeks produk dengan pesan sukses.
        return redirect()->route('products.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
