<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return response()->json([
            'success'   => true,
            'message'   => 'List data products',
            'categories'    => $products
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();

        if ($product) {
            return response()->json([
                'success'       => true,
                'message'       => 'detail data product',
                'product'       => $product
            ], 200);
        }else {
            return response()->json([
                'success'   => false,
                'message'   => 'data product tidak ditemukan'
            ], 400);
        }
    }
}
