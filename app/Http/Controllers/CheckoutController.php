<?php

namespace App\Http\Controllers;

use App\Mail\CheckoutMail;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function checkoutPost(Request $request): \Illuminate\Http\RedirectResponse
    {
        request()->validate([
            'name' => 'required',
            'details' => 'required',
            'comments' => 'required',
        ]);

        $productIds = array_column(session()->get('cart'), 'product_id');
        $products = Product::whereIn('id', $productIds)->get();

        $total=collect($products);

        $order = new Order();
        $order->fill(['user_name'=>$request->input('name'),
            'details'=>$request->input('details'),
            'price'=>$total->sum(function ($product) {return $product['price'];})]);
        $order->save();
        $order->products()->attach($products);

        Mail::to('razvandrelciuc@gmail.com')->send(new CheckoutMail($order));

        session()->forget('cart');

        if ($request->expectsJson()) {
            return response()->json(['message' => 'checkout complete']);
        }

        return redirect()->route('index');
    }
}
