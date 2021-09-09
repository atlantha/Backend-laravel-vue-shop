<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return response()->json([
            'success'   => true,
            'message'   => 'List data category',
            'categories'    => $categories
        ]);
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->first();

        if ($category) {
            return response()->json([
                'success'       => true,
                'message'       => 'List product by category:'. $category->name,
                'product'       => $category->products()->latest()->get(),
            ], 200);
        }else {
            return response()->json([
                'success'   => false,
                'message'   => 'Data product by caegory tidak ditemukan'
            ], 400);
        }
    }

    public function categoryHeader()
    {
        $categories = Category::latest()->take(5)->get();
        return response()->json([
            'success'   => true,
            'message'   => 'list data category header',
            'categories'   => $categories
        ]);
    }
}
