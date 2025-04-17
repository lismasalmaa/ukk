@extends('template.layout')

@section('container')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-flex align-items-center">
                            <li class="breadcrumb-item"><a href="index.html" class="link"><i
                                        class="mdi mdi-home-outline fs-4"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Produk</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Produk</h1>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.product.updateEdit', $products->id) }}" method="POST"
                                enctype="multipart/form-data" class="form-horizontal form-material mx-2">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12">Nama Produk</label>
                                            <div class="col-md-12">
                                                <input type="text" id="name" name="name"
                                                    value="{{ $products->name }}" class="form-control form-control-line">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Harga</label>
                                            <div class="col-md-12">
                                                <input type="text" id="price" name="price"
                                                    value="Rp. {{ number_format($products->price, 0, ',', '.') }}"
                                                    class="form-control form-control-line">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12">Gambar Produk</label>
                                            <div class="col-md-12">
                                                <input type="file" name="image" value="{{ $products->image }}"
                                                    class="form-control form-control-line">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Stok</label>
                                            <div class="col-md-12">
                                                <input type="number" name="stock" value="{{ $products->stock }}"
                                                    class="form-control form-control-line" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-end">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('price').addEventListener('input', function(e) {
                                            let value = e.target.value.replace(/\D/g, ''); // Hapus karakter non-angka
                                            if (value) {
                                                value = new Intl.NumberFormat('id-ID').format(value); // Format angka ke ribuan
                                                e.target.value = 'Rp ' + value; // Tambahkan Rp di depan
                                            } else {
                                                e.target.value = '';
                                            }
                                        });
                                    </script>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
