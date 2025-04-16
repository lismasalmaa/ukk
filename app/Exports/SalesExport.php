<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'Nama Pelanggan',
            'No HP Pelanggan',
            'Poin Pelanggan',
            'Produk',
            'Total Harga',
            'Total Bayar',
            'Total Diskon',
            'Total Kembalian',
            'Tanggal Pembelian',
        ];
    }

    public function collection()
    {
        return Sale::with(['member', 'product'])->get()->map(function ($sale) {
            return [
                'Nama Pelanggan'  => $sale->member->name ?? 'Bukan Member',
                'No HP Pelanggan' => $sale->member->telephone ?? '-',
                'Poin Pelanggan'  => $sale->member->point ?? '',
                'Produk'          => $sale->sales_products,
                'Total Harga'     => 'Rp ' . number_format($sale->total_price, 0, ',', '.'),
                'Total Bayar'     => 'Rp ' . number_format($sale->total_pay, 0, ',', '.'),
                'Total Diskon'    => $sale->used_point > 0 ? 'Rp ' . number_format($sale->discount, 0, ',', '.') : 'Rp 0',
                'Total Kembalian' => 'Rp ' . number_format($sale->total_return, 0, ',', '.'),
                'Tanggal Beli'    => $sale->created_at->format('d-m-Y'),
            ];
        });
    }
}
