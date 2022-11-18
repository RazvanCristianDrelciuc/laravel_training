<?php

namespace App\Http\Controllers;

use App\Mail\CheckoutMail;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $products = [];
        if (!empty(session('cart'))) {
            $products = Product::whereIn('id', session('cart'))->get();
        }

        if ($request->expectsJson()) {
            return response($products);
        }

        return view('cart', compact('products'));
    }
}
