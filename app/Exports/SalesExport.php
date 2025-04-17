<?php

namespace App\Exports;

use App\Models\Member;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SalesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $groupedSales;
    protected $members;

    public function __construct(Collection $filteredSales)
    {
        // Mengelompokkan sales berdasarkan invoice_number
        $this->groupedSales = $filteredSales->groupBy('invoice_number');
    
        // Preload semua member untuk menghindari N+1 query
        $this->members = Member::all()->keyBy('id');
    }

    /**
     * Mengambil koleksi data yang sudah difilter
     */
    public function collection()
    {
        // Ambil satu sales per invoice untuk representasi baris di export
        return $this->groupedSales->map(function ($items) {
            return $items->first(); // Ambil yang pertama dari setiap group
        })->values();
    }

    /**
     * Menyusun data yang akan dimasukkan ke dalam baris Excel
     */
    public function map($sale): array
    {
        // Ambil semua sales untuk invoice yang sama
        $salesByInvoice = $this->groupedSales[$sale->invoice_number];

        // Ambil data member dari koleksi preload
        $member = $this->members[$sale->member_id] ?? null;

        // Format produk
        $produkStr = '';
        foreach ($salesByInvoice as $item) {
            $product = json_decode($item->product_data, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($product)) {
                $nama = $product['nama'] ?? 'Produk';
                $jumlah = $product['jumlah'] ?? 0;
                $subtotal = $product['subtotal'] ?? 0;
                $produkStr .= "{$nama} ( {$jumlah} : Rp. " . number_format($subtotal, 0, ',', '.') . " ), ";
            }
        }
        $produkStr = rtrim($produkStr, ', '); // Menghapus koma terakhir

        // Hitung total
        $subtotal = $salesByInvoice->sum('subtotal');
        $totalPaid = $sale->total_paid ?? 0;
        $diskonPoin = $sale->total_discount ?? 0;
        $kembalian = $totalPaid - $subtotal;

        // dd($member);y

        return [
            $member->name ?? 'Bukan Member',
            $member->telephone ?? '-',
            $member->point ?? '-',
            $produkStr,
            'Rp ' . number_format($sale->total_price, 0, ',', '.'),
            'Rp ' . number_format($sale->total_pay, 0, ',', '.'),
            $sale->used_point > 0 ? 'Rp ' . number_format($sale->discount, 0, ',', '.') : 'Rp 0',
            'Rp ' . number_format($sale->total_return, 0, ',', '.'),
            $sale->created_at->format('d-m-Y'),
            optional($sale->created_at)->format('d-m-Y'),
        ];
    }

    /**
     * Judul kolom untuk file Excel
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
            'Total Diskon Poin',
            'Total Kembalian',
            'Tanggal Pembelian',
        ];
    }
}
