<!DOCTYPE html> <!-- Deklarasi tipe dokumen sebagai HTML5 -->
<html lang="en"> <!-- Tag pembuka untuk HTML dengan bahasa konten Inggris -->
<head>
    <meta charset="UTF-8"> <!-- Menetapkan karakter encoding sebagai UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Memastikan halaman responsif pada perangkat -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> <!-- Memastikan kompatibilitas dengan Internet Explorer -->
    <title>Edit Products - SantriKoding.com</title> <!-- Judul halaman -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Menghubungkan CSS Bootstrap -->
</head>
<body style="background: lightgray"> <!-- Warna latar belakang halaman diatur ke abu-abu terang -->

    <div class="container mt-5 mb-5"> <!-- Container untuk tata letak yang terpusat dengan margin atas dan bawah -->
        <div class="row"> <!-- Membuat baris untuk mengatur kolom -->
            <div class="col-md-12"> <!-- Kolom dengan lebar penuh pada perangkat sedang ke atas -->
                <div class="card border-0 shadow-sm rounded"> <!-- Kartu dengan tepi tanpa batas, bayangan halus, dan sudut membulat -->
                    <div class="card-body"> <!-- Bagian isi kartu -->

                        <!-- Formulir untuk mengedit produk, mengirim data ke route update produk -->
                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        
                            @csrf <!-- Token CSRF untuk keamanan -->
                            @method('PUT') <!-- Metode PUT untuk permintaan pembaruan -->

                            <div class="form-group mb-3"> <!-- Grup input gambar produk -->
                                <label class="font-weight-bold">IMAGE</label> <!-- Label untuk input gambar -->
                                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image"> <!-- Input gambar dengan validasi -->
                            
                                <!-- Menampilkan pesan error jika input gambar tidak valid -->
                                @error('image')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3"> <!-- Grup input judul produk -->
                                <label class="font-weight-bold">TITLE</label> <!-- Label untuk input judul -->
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $product->title) }}" placeholder="Masukkan Judul Product"> <!-- Input judul dengan validasi -->
                            
                                <!-- Menampilkan pesan error jika input judul tidak valid -->
                                @error('title')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3"> <!-- Grup input deskripsi produk -->
                                <label class="font-weight-bold">DESCRIPTION</label> <!-- Label untuk input deskripsi -->
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" placeholder="Masukkan Description Product">{{ old('description', $product->description) }}</textarea> <!-- Input teks area deskripsi dengan validasi -->
                            
                                <!-- Menampilkan pesan error jika input deskripsi tidak valid -->
                                @error('description')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row"> <!-- Baris untuk input harga dan stok -->
                                <div class="col-md-6"> <!-- Kolom input harga -->
                                    <div class="form-group mb-3"> <!-- Grup input harga produk -->
                                        <label class="font-weight-bold">PRICE</label> <!-- Label untuk input harga -->
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}" placeholder="Masukkan Harga Product"> <!-- Input harga dengan validasi -->
                                    
                                        <!-- Menampilkan pesan error jika input harga tidak valid -->
                                        @error('price')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6"> <!-- Kolom input stok -->
                                    <div class="form-group mb-3"> <!-- Grup input stok produk -->
                                        <label class="font-weight-bold">STOCK</label> <!-- Label untuk input stok -->
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="Masukkan Stock Product"> <!-- Input stok dengan validasi -->
                                    
                                        <!-- Menampilkan pesan error jika input stok tidak valid -->
                                        @error('stock')
                                            <div class="alert alert-danger mt-2">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-md btn-primary me-3">UPDATE</button> <!-- Tombol submit untuk mengirim formulir -->
                            <button type="reset" class="btn btn-md btn-warning">RESET</button> <!-- Tombol reset untuk mereset formulir -->

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS untuk interaksi dan CKEditor untuk editor deskripsi -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description'); <!-- Mengaktifkan CKEditor pada textarea deskripsi -->
    </script>
</body>
</html>
