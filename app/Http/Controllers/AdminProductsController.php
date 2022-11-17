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
        return view('products.index', [
            'products' => $products,
        ]);
    }

    public function create(Request $request)
    {
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

        if (file_exists(public_path('/storage/images/' . $product->image))) {
            unlink(public_path('/storage/images/' . $product->image));
        } else {
            dd('File does not exists.');
        }

        $product->fill(['title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $this->uploadImage($request->image),
        ]);
        $product->update();

        return redirect()->route('products.index');
    }

    public function destroy($id, Request $request)
    {
        $product = Product::findOrFail($id);

        if (file_exists(public_path('/storage/images/' . $product->image))) {
            unlink(public_path('/storage/images/' . $product->image));
        } else {
            allert('File does not exists.');
            return redirect()->route('products.index');
        }
        $product->delete();
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
            'image' => 'image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $product = new Product;
        $product->fill(['title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' => $this->uploadImage($request->image)
        ]);
        $product->save();

        return redirect()->route('products.index');

    }

    function uploadImage($image)
    {
        $fileExt = $image->extension();
        $imageName = hash('sha1', $image);
        $image->move(storage_path('app/public/images/'), $imageName . '.' . $fileExt);
        return $imageName . '.' . $fileExt;
    }

    public function edit($id, Request $request)
    {
        $product = Product::findOrFail($id);

        return view('product', ['product' => $product]);
    }
}
