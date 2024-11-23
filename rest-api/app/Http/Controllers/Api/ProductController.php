<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //
    public function index ()
    {
        $products = Product::get();
        if ($products -> count() > 0)
        {
            return ProductResource::collection($products);
        }
        else {
            return response()->json(['message' => 'No record available'], 200);
        }

    }

    public function store (Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'All fields are mandatory',
                'error' => $validator->messages(),
            ], 422);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|integer'
        ]);

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);

        return response() -> json([
            'message' => 'Product created successfully',
            'data' => new ProductResource($product)
    ], 200);
        
    }

    public function show (Product $product)
    {
        return new ProductResource($product);
        
    }

    public function update () {
        
    }

    public function destroy () {
        
    }
}