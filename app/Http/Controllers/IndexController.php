<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $products = Product::all();
        if (session('cart')) {
            $productIds = array_column(session()->get('cart'), 'product_id');
        } else {
            $productIds = [];
        }
        return view('index.index', ['products' => Product::whereNotIn('id', $productIds)->get()]);
    }
}
