<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AdminProductsController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
        if ($request->expectsJson()) {
            return response($products);
        }
        return view('products.index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        return view('product');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);

        $product = Product::find($id);
        $product->fill(['title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $request->input('image')]);
        $product->update();

        return redirect()->route('products.index');
    }

    public function destroy($id, Request $request)
    {
        $productRemove = Product::find($id);
        $productRemove->delete();
        if (session()->exists('cart')) {
            foreach (session('cart') as $key => $val) {
                if ($val['product_id'] == $id) {
                    session()->pull('cart.' . $key);
                }
            }
        }
        return redirect()->route('products.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);

        $product = new Product;
        $product->fill(['title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $request->input('image')]);
        $product->save();

        return redirect()->route('products.index');
    }

    public function edit($id, Request $request)
    {
        if (!$id) {
            if ($request->expectJson()) {
                return response()->json('product to edit dose not exist');
            } else {
                return redirect()->back();
            }
        }

        $product = Product::find($id);

        if ($request->expectsJson()) {
            return response($product);
        }

        return view('product', ['product' => $product]);
    }
}
