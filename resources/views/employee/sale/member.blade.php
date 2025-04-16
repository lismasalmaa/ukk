@extends('template.layout')

@section('container')
<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 d-flex align-items-center">
                        <li class="breadcrumb-item"><a href="/" class="link"><i class="mdi mdi-home-outline fs-4"></i></a></li>
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
                    <form action="{{route('employee.sale.updateSale',$sale->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="table table-bordered">
                                    <table>
                                        <tbody>
                                            <tr class="tabletitle">
                                                <td class="item">
                                                    Nama Produk
                                                </td>
                                                <td class="item">
                                                    QTy
                                                </td>
                                                <td class="item">
                                                    Harga
                                                </td>
                                                <td class="item">
                                                    Sub Total
                                                </td>
                                            </tr>
                                            @foreach ($detail_sale as $detail)
                                                <tr class="service">
                                                    <td class="tableitem">
                                                        <p class="itemtext">{{ $detail->product->name }}</p>
                                                    </td>
                                                    <td class="tableitem">
                                                        <p class="itemtext">{{ $detail->quantity }}</p>
                                                    </td>
                                                    <td class="tableitem">
                                                        <p class="itemtext">{{ 'Rp. ' . number_format($detail->product['price'], 0, ',', '.') }}</p>
                                                    </td>
                                                    <td class="tableitem">
                                                        <p class="itemtext">{{ 'Rp. ' . number_format($detail['sub_total'], 0, ',', '.') }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr class="tabletitle">
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <h4>Total Harga</h4>
                                                </td>
                                                <td>
                                                    <h4>{{ 'Rp. ' . number_format($sale['total_price'], 0, ',', '.') }}</h4>
                                                </td>
                                            </tr>
                                            <tr class="tabletitle">
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <h4>Total Bayar</h4>
                                                </td>
                                                <td>
                                                    <h4>{{ 'Rp. ' . number_format($sale['total_pay'], 0, ',', '.') }}</h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="row">
                                    <input type="hidden" name="sale_id" value="{{$sale->id}}">
                                    <input type="hidden" name="member_id" value="{{$sale->member->id}}">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Nama Member (identitas)</label>
                                        <input type="text" name="name" id="name" class="form-control" required
                                            value="{{ $sale->member->name ?? ''}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="poin" class="form-label">Poin</label>
                                        <input type="text" name="point" id="point" value="{{ $sale->member ? $sale->member->point : ''}}" disabled=""
                                            class="form-control">
                                    </div>
                                    <div class="form-check ms-4">
                                        <input class="form-check-input" type="checkbox" value="Ya" id="check2"
                                            {{ $isFirst ? 'disabled' : ''}} name="check_poin">
                                        <label class="form-check-label" for="check2">
                                            Gunakan poin
                                        </label>
                                        @if ($isFirst)
                                            <small class="text-danger">Poin tidak dapat digunakan pada pembelanjaan
                                                pertama.</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row text-end">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit">Selanjutnya</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection