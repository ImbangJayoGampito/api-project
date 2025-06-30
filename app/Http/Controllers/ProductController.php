<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return ProductResource::collection($products);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {

            return response()->json([
                'status' => 'error',
                'message' => 'Resource not found'
            ], 404);
        }
        return new ProductResource($product);
    }

    public function store(Request $request)
    {
        $storeProductRequest = new StoreProductRequest();
        $validator = Validator::make($request->all(), $storeProductRequest->rules(), $storeProductRequest->messages());
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }
        $validated = $validator->validated();
        $product = Product::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully',
            'data' => $product
        ], 201);
    }



    public function update(Request $request, Product $product)
    {
        $storeProductRequest = new StoreProductRequest();

        $validator = Validator::make($request->all(), $storeProductRequest->rules(), $storeProductRequest->messages());
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors(),
            ], 422);
        }
        $validated = $validator->validated();

        $product->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => $product
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {

            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }
        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ]);
    }
}
