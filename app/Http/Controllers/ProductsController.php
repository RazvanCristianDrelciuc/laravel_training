<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index(Request $request)
    {
        (session('cart') ? $productIds = array_column(session()->get('cart'), 'product_id') : $productIds = []);

        if ($request->expectsJson()) {
            return response(Product::whereNotIn('id', $productIds)->get());
        }

        return view('index.index', ['products' => Product::whereNotIn('id', $productIds)->get()]);
    }


    public function store(Request $request, $id)
    {
        $product = Product::find($id);
        $product = ['product_id' => $id];
        $productIds = $request->session()->has('cart') ? array_column(session()->get('cart'), 'product_id') : [];
        if (!(in_array($id, $productIds))) {
            $request->session()->push('cart', $product);
        }

        if ($request->expectsJson()) {
            return response()->json(['message'=>'has been added to the Cart']);
        }
        return redirect()->route('index');
    }

    public function destroy($id, Request $request)
    {
        foreach (session('cart') as $key => $val) {
            if ($val['product_id'] == $id) {
                session()->pull('cart.' . $key);
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'has been removed to the Cart']);
        }

        return redirect()->route('cart.index');
    }

    public function main()
    {
        return view('main');
    }
}
