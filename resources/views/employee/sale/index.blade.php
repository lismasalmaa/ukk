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
                            <li class="breadcrumb-item active" aria-current="page">Penjualan</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Penjualan</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <div class="p-4 d-flex justify-content-between align-items-center flex-wrap">
                                <a href="{{ route('employee.sale.exportExcel') }}" class="btn btn-info mr-2">Ekspor
                                    Penjualan (.xlsx)</a>

                                <a href="{{ route('employee.sale.create') }}" class="btn btn-primary mt-2 mt-md-0">Tambah
                                    Penjualan</a>
                            </div>

                            <div class="table-responsive">
                                <table id="tabel-data" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama Pelanggan</th>
                                            <th scope="col">Tanggal Penjualan</th>
                                            <th scope="col">Total Harga</th>
                                            <th scope="col">Dibuat Oleh</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sales as $sale)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                @if ($sale->member)
                                                    <td>{{ $sale->member->user->name?? 'BUKAN MEMBER' }}</td>
                                                @else
                                                    <td>BUKAN MEMBER</td>
                                                @endif
                                                <td>{{ $sale->sale_date }}</td>
                                                <td>Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</td>
                                                <td>{{ $sale->user->name }}</td>
                                                <td>
                                                    <a href="" data-bs-target="#show-{{ $sale->id }}"
                                                        data-bs-toggle="modal" class="btn btn-warning me-2">Lihat</a>
                                                    <a href="{{ route('employee.sale.exportPDF', $sale->id) }}"
                                                        class="btn btn-info me-2">Unduh Bukti</a>
                                                </td>
                                            </tr>
                                            <div class="modal" tabindex="-1" id="show-{{ $sale->id }}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLihat">Detail Penjualan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <small>
                                                                        <strong>Member Status :
                                                                            {{ $sale->member ? 'Member' : 'Bukan Member' }}</strong><br>
                                                                        <strong>No. HP :
                                                                            {{ $sale->member ? $sale->member->telephone : '-' }}</strong><br>
                                                                        <strong>Poin Member :
                                                                            {{ $sale->member ? $sale->member->point : 0 }}</strong>
                                                                    </small>
                                                                </div>
                                                                <div class="col-6">
                                                                    <small>
                                                                        <strong>Bergabung Sejak :
                                                                            {{ $sale->member ? $sale->member->created_at->format('d F Y') : '-' }}</strong>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3 text-center mt-5">
                                                                <div class="col-3"><b>Nama Produk</b></div>
                                                                <div class="col-3"><b>Qty</b></div>
                                                                <div class="col-3"><b>Harga</b></div>
                                                                <div class="col-3"><b>Sub Total</b></div>
                                                            </div>
                                                            @foreach ($detail_sale as $item)
                                                                @if ($sale->id == $item->sale_id)
                                                                    <div class="row mb-1">
                                                                        <div class="col-3 text-center">
                                                                            {{ $item->product ? $item->product->name : '-' }}
                                                                        </div>
                                                                        <div class="col-3 text-center">
                                                                            {{ $item->quantity }}
                                                                        </div>
                                                                        <div class="col-3 text-center">
                                                                            {{ 'Rp. ' . number_format($item->product['price'], 0, ',', '.') }}
                                                                        </div>
                                                                        <div class="col-3 text-center">
                                                                            {{ 'Rp. ' . number_format($item['sub_total'], 0, ',', '.') }}
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                            <div class="row text-center mt-3">
                                                                <div class="col-9 text-end"><b>Total</b></div>
                                                                <div class="col-3">
                                                                    @if ($sale->used_point > 0)
                                                                        <b>{{ 'Rp. ' . number_format($sale['discount'], 0, ',', '.') }}</b>
                                                                    @else
                                                                        <b>{{ 'Rp. ' . number_format($sale['total_price'], 0, ',', '.') }}</b>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <center>
                                                                    Dibuat pada : {{ $sale->created_at }}
                                                                    <br> Oleh :
                                                                    {{ $sale->user->name }}
                                                                </center>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{ route('employee.sale.index') }}"
                                                                class="btn btn-secondary" data-bs-dismiss="modal">Tutup</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.min.css"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabel-data').DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    emptyTable: "Tidak ada data yang tersedia"
                }
            });
        });
    </script>
@endsection
