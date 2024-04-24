<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = \App\Models\Product::paginate(5);
        return view('pages.product.index', compact('products'));
    }

    public function create(){
        $categories = \App\Models\Category::all();
        return view('pages.product.create', compact('categories'));
    }

    public function store(Request $request){
        // $data = $request->all();
        // $data['image'] = $request->file('image')->store('assets/product', 'public');
        // \App\Models\Product::create($data);
        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);
        // $data = $request->all();

        $product = new \App\Models\Product;
        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->image = $filename;
        $product->save();

        return redirect()->route('product.index');
    }

    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = \App\Models\Category::all();
        return view('pages.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        if ($request->image) {
            $filename = time() . '' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);
            $product->image = $filename;
        }

        $product->update($request->all());

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
}
