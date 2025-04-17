@extends('template.layout')

@section('container')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#6c5ce7'
            });
        </script>
    @endif
    @if (session('failed'))
        <script>
            Swal.fire({
                icon: 'error',
                text: '{{ session('failed') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#6c5ce7'
            });
        </script>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <div class="table-responsive">
                            <table class="table">
                                <div class="p-4 text-end">
                                    <a href="{{ route('admin.product.create') }}" type="button"
                                        class="btn btn-primary">Tambah Produk</a>
                                </div>
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Stok</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td><img src="{{ asset('storage/' . $product->image) }}" width="100"></td>
                                            <td>{{ $product->name }}</td>
                                            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>
                                                <div class="text-center">
                                                    <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}"
                                                        type="button" class="btn btn-warning update-edit-btn me-2"
                                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                                        data-price="{{ $product->price }}"
                                                        data-image="{{ $product->image }}"
                                                        data-stock="{{ $product->stock }}" data-bs-toggle="modal">Edit</a>
                                                    <button type="button" class="btn btn-info update-stok-btn me-2"
                                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                                        data-stock="{{ $product->stock }}" data-bs-toggle="modal"
                                                        data-bs-target="#updateStokModal">Update Stok</button>
                                                    <form action="{{ route('admin.product.destroy', $product->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('hapus?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateStokModal" tabindex="-1" aria-labelledby="updateStokModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStokModalLabel">Edit Stok Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateStokForm" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" id="produk_id" name="produk_id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="name" name="name" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stock" name="stock">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".update-stok-btn").click(function() {
                let id = $(this).data("id");
                let name = $(this).data("name");
                let stock = $(this).data("stock");

                $("#produk_id").val(id);
                $("#name").val(name);
                $("#stock").val(stock);
            });

            $("#updateStokForm").submit(function(e) {
                e.preventDefault();

                let produkId = $("#produk_id").val();
                let stokBaru = $("#stock").val();

                $.ajax({
                    url: "/admin/product/updateStock/" + produkId,
                    method: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        stock: stokBaru
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.success,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    },

                    error: function(xhr) {
                        alert("Gagal memperbarui stok!");
                        console.log(xhr.responseText);
                    }
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

            });

            $(".update-stok-btn").click(function() {
                let id = $(this).data("id");
                let name = $(this).data("name");
                let stock = $(this).data("stock");

                $("#produk_id").val(id);
                $("#name").val(name);
                $("#stock").val(stock);

                $("#updateStokForm").attr("action", "{{ url('admin/product/updateStock') }}/" + id);
            });


        });
    </script>
@endsection
