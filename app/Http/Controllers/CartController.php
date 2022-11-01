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
        $cart = session()->get('cart');
        if ($cart == null) {
            $cart = [];
        }

        (session('cart') ? $productIds = array_column(session()->get('cart'), 'product_id') : $productIds = []);

        if ($request->ajax()) {
            return response()->json([
                'products' => Product::whereIn('id', $productIds)->get(),]);
        }

        return view('cart', ['products' => Product::whereIn('id', $productIds)->get()]);
    }
}
