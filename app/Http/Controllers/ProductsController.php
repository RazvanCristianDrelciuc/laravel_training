<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', [
            'products' => $products,
        ]);
    }

    public function addTocart(Request $request, $id)
    {
        $product = Product::find($id);

        $product = ['product_id' => $id];
        $productIds = $request->session()->has('cart') ? array_column(session()->get('cart'), 'product_id') : [];
        if (!(in_array($id, $productIds))) {
            $request->session()->push('cart', $product);
        }

        return redirect()->route('index');
    }

    public function removeFromCart($id)
    {
        foreach(session('cart') as $key =>$val){
            if ($val['product_id'] == $id) {
                session()->pull('cart.' . $key);
            }
        }
        return redirect()->route('products');
    }

    public function deleteProduct($id){

        $productRemove=Product::find($id);
        $productRemove->delete();
        return redirect()->route('products');
    }
    public function updateProduct($id){
        return view('product');
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $product = Product::all();
        return view('product', [
            'products' => $products,
        ]);

    }


    public function edit(Product $proudct)
    {
        //
    }


    public function update(Request $request, Product $proudct)
    {
        //
    }


    public function destroy(Product $proudct)
    {
        //
    }
}
