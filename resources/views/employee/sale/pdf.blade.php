<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .struk {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
<<<<<<< HEAD
            text-align: right;
            float: left;
=======
            text-align: left;
>>>>>>> 01f517eb54fb37af3f3c289602eeca206ab7c229
            padding: 12px;
            border: none;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
        }

        .header-info {
            margin-bottom: 20px;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 10px;
        }

        .header-info p {
            margin-bottom: 5px;
        }

        .product-name {
            font-weight: bold;
        }

        .total-info p:nth-child(even) {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="struk">
        <h4 class="text-center mb-4">Indo April</h4>
        <div class="header-info">
            @if ($sale->member)
                <p><strong>Member Status : </strong>{{ $sale->member ? 'Member' : 'Bukan Member' }}</p>
                <p><strong>No. HP : </strong>{{ $sale->member->telephone }}</p>
                <p><strong>Bergabung Sejak : </strong>{{ $sale->member->created_at->format('d F Y') }}</p>
                <p><strong>Poin Member : </strong>{{ $sale->member->point }}</p>
            @else
                <p><strong>Member Status : </strong>Bukan Member</p>
                <p><strong>No. HP : </strong>-</p>
                <p><strong>Bergabung Sejak : </strong>-</p>
                <p><strong>Poin Member : </strong>-</p>
            @endif
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detail_sale as $sales)
                    <tr>
                        <td>{{ $sales->product->name }}</td>
                        <td>{{ $sales->quantity }}</td>
                        <td>Rp {{ number_format($sales->product->price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($sales->sub_total, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th></th>
                    <th></th>
                    <th>Total Harga</th>
                    @if ($sale->used_point > 0)
                        <th>Rp. {{ number_format($sale->discount, 0, ',', '.') }}</th>
                    @else
                        <th>Rp. {{ number_format($sale->total_price, 0, ',', '.') }}</th>
                    @endif
                </tr>
                <tr>
                    <th>Poin Digunakan</th>
                    <th>{{ $sale->used_point }}</th>
                    <th>Harga Setelah Poin</th>
                    @if ($sale->used_point > 0)
                        <th>Rp. {{ number_format($sale->discount, 0, ',', '.') }}</th>
                    @else
                        <th>Rp. 0</th>
                    @endif
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Total Kembalian</th>
                    <th>Rp {{ number_format($sale->total_return, 0, ',', '.') }}</th>
                </tr>
            </tbody>
        </table>
        <div class="footer">
            <p>{{ now()->format('d-m-Y') }}T{{ now()->format('H:i:s') }}.000000Z | {{ $sale->user->name }}</p>
            <p>Terima kasih atas pembelian Anda!</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
