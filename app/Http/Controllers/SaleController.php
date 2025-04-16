<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Imports\SaleImport;
use App\Models\Detail_sale;
use App\Models\Member;
use App\Models\Product;
use App\Models\Sale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    public function indexEmployee(Request $request)
    {
        $user = Auth::user();
        $detail_sale = Detail_sale::all();
        $sales = Sale::with('member', 'user')->orderBy('id', 'desc')->get();
        return view('employee.sale.index', compact('sales', 'detail_sale', 'user'));
    }

    public function indexAdmin(Request $request)
    {
        $detail_sale = Detail_sale::all();
        $sales = Sale::with('member', 'user')->orderBy('id', 'desc')->get();
        return view('admin.sale.index', compact('sales','detail_sale'));

        // $sales = Sale::with('member', 'user')->latest()->get();

        // // Teruskan data pengguna ke view
        // return view('admin.sale.index', [
        //     'sales' => $sales,
        //     'user' => auth()->user(),  // Teruskan pengguna yang sedang login
        // ]);
    }


    public function create()
    {
        $products = Product::all();
        return view('employee.sale.create', compact('products'));
    }

    public function store(Request $request)
    {
        $products = $request->products;

        if (empty($products)) {
            return redirect()->back()->with('failed', 'Pilih produk terlebih dahulu.');
        }

        $data['products'] = [];
        $data['total'] = 0;
        foreach ($products as $product) {
            $product = explode(';', $product);
            $id = $product[0];
            $name = $product[1];
            $price = $product[2];
            $quantity = $product[3];
            $subtotal = $product[4];

            $data['products'][] = [
                'product_id' => $id,
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'sub_total' => $subtotal,
            ];
            $data['total'] += $subtotal;
        }

        return view('employee.sale.payment', $data);
    }

    public function paymentProccess(Request $request)
    {
        $products = $request->shop;
        $sales_products = [];
        $total_pay = (int)str_replace(['Rp. ', '.'], '', $request->total_pay);
        $total = (int)$request->total;
        $member_id = null;

        if ($request->member == 'Member') {
            $telephone = $request->telephone;
            $name = $request->name;
            $existMember = Member::where('telephone', $telephone)->first();

            if ($existMember) {
                $existMember->update([
                    'point' => $existMember->point + ($total / 100),
                ]);
                $member_id = $existMember->id;
            } else {
                $newMember = Member::create([
                    'name' => $name,
                    'telephone' => $telephone,
                    'point' => $total / 100,
                ]);
                $member_id = $newMember->id;
            }
        }

        $sale = Sale::create([
            'sale_date' => now(),
            'member_id' => $member_id,
            'total_price' => $total,
            'discount' => 0,
            'total_pay' => $total_pay,
            'total_return' => $total_pay - $total,
            'user_id' => Auth::user()->id,
            'sales_products' => implode(', ', $sales_products) ?? '',
            'point' => $total / 100,
            'used_point' => 0
        ]);

        foreach ($products as $product) {
            $product = explode(';', $product);
            $id = $product[0];
            $name = $product[1];
            $price = number_format($product[2], 0, ',', '.');
            $quantity = (int)$product[3];
            $subtotal = (int)$product[4];

            $sales_products[] = "{$name} ( {$quantity} : Rp. {$price} )";

            $productModel = Product::find($id);
            if ($productModel) {
                $productModel->update(['stock' => $productModel->stock - $quantity]);
            }

            Detail_sale::create([
                'sale_id' => $sale->id,
                'product_id' => $id,
                'quantity' => $quantity,
                'sub_total' => $subtotal,
            ]);
        }

        $sale->update(['sales_products' => implode(' , ', $sales_products)]);

        if ($request->member == 'Member') {
            return redirect()->route('employee.sale.member', $sale->id);
        }

        return redirect()->route('employee.sale.print', $sale->id);
    }

    public function member($id)
    {
        $sale = Sale::findOrFail($id);
        $isFirst = Sale::where('member_id', $sale->member_id)->count() == 1 ? true : false;
        $detail_sale = Detail_sale::where('sale_id', $sale->id)->get();
        return view('employee.sale.member', compact('sale', 'detail_sale', 'isFirst'));
    }

    public function updateSale(Request $request, $id)
    {
        $sale = Sale::with('member')->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        if ($request->check_poin == 'Ya') {
            $sale->update([
                'used_point' => $sale->member->point,
                'total_price' => $sale->total_price,
                'discount' => $sale->total_price - $sale->member->point,
                'total_return' => $sale->total_return + $sale->member->point,
            ]);
            $sale->member->update([
                'name' => $request->name,
                'point' => 0,
            ]);
        } else {
            $sale->member->update([
                'name' => $request->name,
            ]);
        }
        return redirect()->route('employee.sale.print', $sale->id);
    }

    public function print($id)
    {
        $sale = Sale::with('member', 'user')->findOrFail($id);
        $detail_sale = Detail_sale::where('sale_id', $sale->id)->with('product')->get();
        return view('employee.sale.print', compact('sale', 'detail_sale'));
    }

    public function exportPDF($id)
    {
        $sale = Sale::with('member', 'user')->findOrFail($id);
        $detail_sale = Detail_sale::where('sale_id', $sale->id)->with('product')->get();

        $data = [
            'sale' => $sale,
            'detail_sale' => $detail_sale,
            'isMember' => $sale->member != null,
        ];
        $pdf = Pdf::loadView('employee.sale.pdf', $data);
        $pdf->setPaper('A4', 'potrait');
        return $pdf->download('receipt.pdf');
    }

    public function exportExcel()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses!');
        } else {
            return Excel::download(new SalesExport, 'laporan-penjualan.xlsx');
        }
    }
}
