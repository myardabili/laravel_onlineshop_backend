<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::when($request->category_id, function ($query) use ($request) {
            return $query->where('category_id', $request->category_id);
        })->paginate(10);

        return response()->json([
            'message' => 'Success',
            'data' => $products,
        ], 200);
    }

    public function getProductById($id) {
        $product = Product::find($id);

        if ($product) {
            return response()->json([
                'message' => 'Success',
                'data' => $product,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('query');

        if (!$searchTerm) {
            return response()->json([
                'message' => 'Search term is required',
            ], 400);
        }

        $products = Product::where('name', 'like', '%' . $searchTerm . '%')->paginate(10);

        return response()->json([
            'message' => 'Success',
            'data' => $products,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
