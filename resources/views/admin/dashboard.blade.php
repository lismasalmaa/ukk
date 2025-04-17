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
                            <li class="breadcrumb-item"><a href="index.html" class="link"><i
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
                <div>
                    <div class="card">
                        <div class="card-body">
                            <div class="d-md-flex align-items-center">
                                <div>
                                    <h4 class="card-title">Selamat datang, {{ Auth::user()->name }}!</h4>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <canvas id="salesChart"></canvas>
                                </div>
                                <div class="col-md-4">
                                    <canvas id="productChart"></canvas>
                                </div>
                            </div>

                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script>
                                var dates = {!! json_encode($dates ?? []) !!};
                                var salesCount = {!! json_encode($salesCount ?? []) !!};
                                var productNames = {!! json_encode($productNames ?? []) !!};
                                var productTotals = {!! json_encode($productTotals ?? []) !!};

                                var ctxBar = document.getElementById('salesChart').getContext('2d');
                                var salesChart = new Chart(ctxBar, {
                                    type: 'bar',
                                    data: {
                                        labels: dates,
                                        datasets: [{
                                            label: 'Jumlah Penjualan',
                                            data: salesCount,
                                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                            borderColor: 'rgba(54, 162, 235, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });

                                var ctxPie = document.getElementById('productChart').getContext('2d');
                                var productChart = new Chart(ctxPie, {
                                    type: 'pie',
                                    data: {
                                        labels: productNames,
                                        datasets: [{
                                            data: productTotals,
                                            backgroundColor: [
                                                '#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff', '#ffa500'
                                            ]
                                        }]
                                    },
                                    options: {
                                        responsive: true
                                    }
                                });
                            </script>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
