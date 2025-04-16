<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function indexAdmin()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    public function indexEmployee()
    {
        $products = Product::all();
        return view('employee.product.index', compact('products'));
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        $net_price = str_replace(['Rp ', '.'], '', $request->price);

        Product::create([
            'name' => $request->name,
            'price' => (int) $net_price,
            'stock' => $request->stock,
            'image' => $request->file('image') ? $request->file('image')->store('product-images', 'public') : null
        ]);

        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $products = Product::find($id);
        return view('admin.product.edit', compact('products'));
    }

    public function updateEdit(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string',   
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        $net_price = preg_replace('/[^\d]/', '', $request->price);

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = (float) $net_price;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('product', 'public');
            $product->image = $path;
        }
        $product->save();

        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function updateStock(Request $request, string $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $product = Product::findOrFail($id);
        $product->stock = $request->stock;
        $product->save();
            
        return response()->json(['success' => 'Stok berhasil diperbarui!'], 200);
    }

    public function destroy(string $id)
    {
        $products = Product::findOrFail($id);

        if (!$products) {
            return redirect()->back()->with('failed', 'Data tidak ditemukan');
        }
        $penjualanUsingProduk = $products->detailSale()->exists();

        if ($penjualanUsingProduk) {
            return redirect()->back()->with('failed', 'Produk sudah digunakan dalam penjualan');
        } else {
        $products->delete();

        return redirect()->route('admin.product.index')->with('success', 'Produk berhasil dihapus.');
        }
    }
}
