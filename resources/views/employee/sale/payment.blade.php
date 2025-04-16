@extends('template.layout')

@section('container')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-flex align-items-center">
                            <li class="breadcrumb-item"><a href="/" class="link"><i
                                        class="mdi mdi-home-outline fs-4"></i></a></li>
                            <li class="breadcrumb-item"><a href="" class="link">Penjualan</a></li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">Penjualan</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('employee.sale.paymentProccess') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <h2>Produk yang dipilih</h2>
                                    <table style="width: 100%;">
                                        <thead>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>{{ $product['name'] }} <br>
                                                        <small>{{ 'Rp. ' . number_format($product['price'], 0, ',', '.') }}
                                                            X
                                                            {{ $product['quantity'] }}</small></td>
                                                    <td><b>{{ 'Rp. ' . number_format($product['sub_total'], 0, ',', '.') }}</b>
                                                    </td>
                                                </tr>
                                                <input type="hidden" name="shop[]"
                                                    value="{{ $product['product_id'] . ';' . $product['name'] . ';' . $product['price'] . ';' . $product['quantity'] . ';' . $product['sub_total'] }}"
                                                    hidden="">
                                            @endforeach
                                            <tr>
                                                <td style="padding-top: 20px; font-size: 20px;"><b>Total</b></td>
                                                <td class="tex-end" id="get_total"
                                                    style="padding-top: 20px; font-size: 20px;">
                                                    <b>{{ 'Rp. ' . number_format($total, 0, ',', '.') }}</b>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <input type="text" name="total" id="total" value="{{ $total }}"
                                        hidden="">
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="member" class="form-label">Member Status</label>
                                            <small class="text-danger">Dapat juga membuat member</small>
                                            <select name="member" id="member" class="form-select"
                                                onchange="memberDetect()">
                                                <option value="Bukan Member">Bukan Member</option>
                                                <option value="Member">Member</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="member-wrap" class="d-none">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-12">No Telepon <small
                                                            class="text-danger">(daftar/gunakan member)</small></label>
                                                    <div class="col-md-12">
                                                        <input type="number" name="telephone"
                                                            class="form-control form-control-line "
                                                            onkeypress="if(this.value.length==13) return false;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="total_pay" class="form-label">Total Bayar</label>
                                            <input type="text" name="total_pay" id="total_pay" class="form-control"
                                                oninput="checkTotalPay()">
                                            <small id="error-message" class="text-danger d-none">Jumlah bayar
                                                kurang.</small>
                                        </div>
                                    </div>
                                    <div class="row text-end">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary" id="submit-button" type="submit"
                                                disabled>Pesan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function checkTotalPay() {
                const totalElement = document.getElementById('total').value;
                const totalPayElement = document.getElementById('total_pay').value;
                const total = parseInt(totalElement.replace(/[^\d]/g, ''));
                const total_pay = parseInt(totalPayElement.replace(/[^\d]/g, ''));

                if (total_pay < total) {
                    document.getElementById('error-message').classList.remove('d-none');
                    document.getElementById('submit-button').disabled = true;
                } else {
                    document.getElementById('error-message').classList.add('d-none');
                    document.getElementById('submit-button').disabled = false;
                }
            }

            function memberDetect() {
                const detectElement = document.getElementById('member');
                const telephone = document.getElementById('member-wrap');
                const is_member = detectElement.value;

                if (is_member == 'Member') {
                    telephone.classList.remove('d-none');
                } else {
                    telephone.classList.add('d-none');
                }
            }

            var totalPayInput = document.getElementById('total_pay');
            totalPayInput.addEventListener('keyup', function(e) {
                totalPayInput.value = formatRupiah(this.value, 'Rp. ');
            });

            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : '');
            }
        </script>
    </div>
@endsection
