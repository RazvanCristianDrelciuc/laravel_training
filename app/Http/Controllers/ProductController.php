<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        if (!empty(session('cart'))) {
            $products = Product::whereNotIn('id', session('cart'))->get();
        } else {
            $products = Product::all();
        }

        if ($request->expectsJson()) {
            return response()->json($products);
        }

        return view('index.index', compact('products'));
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->input('id_product'));
        session()->push('cart', $product->id);

        if ($request->expectsJson()) {
            return response()->json(['message'=>'has been added to the Cart']);
        }

        return redirect()->route('index');
    }

    public function destroy($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $cart= session()->pull('cart', []);
        if(($key = array_search($product->id, $cart)) !== false) {
            unset($cart[$key]);
        }
        session()->put('cart', $cart);

        if ($request->expectsJson()) {
            return response()->json();
        }

        return redirect()->route('cart.index');
    }

    public function main()
    {
        return view('main');
    }
}
