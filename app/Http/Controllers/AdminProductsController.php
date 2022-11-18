<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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

    public function create(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json();
        }

        return view('product');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:10240',
        ]);

        if ($request->hasFile('image')) {

            if (file_exists(public_path('/storage/images/' . $product->image))) {
                unlink(public_path('/storage/images/' . $product->image));
            }

            $product->fill([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'image' => $this->uploadImage($request->image),
            ]);
        } else {
            $product->fill([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'price' => $request->input('price'),
                'image' => $product->image,
            ]);
        }
        $product->update();

        if ($request->expectsJson()) {
            return response()->json();
        }

        return redirect()->route('products.index');
    }

    public function destroy($id, Request $request)
    {
        $product = Product::findOrFail($id);

        if (file_exists(public_path('/storage/images/' . $product->image))) {
            unlink(public_path('/storage/images/' . $product->image));
        } else {
            return redirect()->route('products.index');
        }
        Product::destroy($id);

        if ($request->expectsJson()) {
            return response()->json();
        }

        return redirect()->route('products.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $product = new Product;
        $product->fill([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $this->uploadImage($request->image)
        ]);
        $product->save();

        return redirect()->route('products.index');

        if ($request->expectsJson()) {
            return response()->json();
        }

        return redirect()->route('products.index');
    }

    function uploadImage($image)
    {
        $fileExt = $image->extension();
        $date = now()->format('Y-m-d-H-i-s');
        $image->move(storage_path('app/public/images/'), $date . '.' . $fileExt);

        return $date . '.' . $fileExt;
    }

    public function edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->expectsJson()) {
            return response($product);
        }

        return view('product', ['product' => $product]);
    }
}
