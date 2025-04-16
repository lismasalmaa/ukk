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
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                        <li class="breadcrumb-item"><a href="" class="link"><i
                                    class="mdi mdi-home-outline fs-4"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
                <h1 class="mb-0 fw-bold">Dashboard</h1>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="">
                <div class="container mt-5">
                    <h4 class="text-center">Selamat Datang, {{ Auth::user()->name }}!</h4>
                    
                    <div class="card shadow-sm mt-4">
                        <div class="card-body text-center">
                            <div class="bg-light py-3 rounded">
                                <h6 class="text-muted">Total Penjualan Hari Ini</h6>
                            </div>
                            <h1 class="mt-3 fw-bold">{{ $totalSales }}</h1>
                            <p class="text-muted">Jumlah total penjualan yang terjadi hari ini.</p>
                            <div class="bg-light py-2 rounded">
                                <small class="text-muted">Terakhir diperbarui: {{ now()->setTimezone('Asia/Jakarta')->format('d M Y H:i') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
