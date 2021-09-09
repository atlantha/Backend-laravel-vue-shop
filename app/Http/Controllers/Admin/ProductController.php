<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Product;
Use App\Models\Category;
Use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->when(request()->q, function($products){
            $products = $products->where('title', 'like', '%', request()->q, '%');
        })->paginate(10);
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::latest()->get();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2000',
            'title'         => 'required|unique:products',
            'category_id'   => 'required',
            'content'       => 'required',
            'weight'        => 'required',
            'price'         => 'required',
            'discount'      => 'required'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        //save to DB
        $product = Product::create([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'slug'          => Str::slug($request->title, '-'),
            'category_id'   => $request->category_id,
            'content'       => $request->content,
            'unit'          => $request->unit,
            'weight'        => $request->weight,
            'price'         => $request->price,
            'discount'      => $request->discount,
        ]);

        if ($product) {
            return redirect()->route('admin.product.index')->with(['success' => 'Data Berhasil Di Simpan']);
        }else {
            return redirect()->route('admin.product.index')->with(['success' => 'Data Gagal Di Simpan']);
        }
    }

    public function edit()
    {
        $categories = Category::latest()->get();
        return view('admin.product.edit', compact('categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'title'         => 'required|unique:products,title,'.$product->id,
            'category_id'   => 'required',
            'content'       => 'required',
            'weight'        => 'required',
            'price'         => 'required',
            'discount'      => 'required'
        ]);

        //cek jika image kosong
        if ($request->file('image') == '') {

            //update tanpa image
            $product = Product::findOrFail($product->id);
            $product->update([
                'title'         => $request->title,
                'slug'          => Str::slug($request->title, '-'),
                'category_id'   => $request->category_id,
                'content'       => $request->content,
                'unit'          => $request->unit,
                'wieght'        => $request->weight,
                'price'         => $request->price,
                'discount'      => $request->discount,
            ]);
        }else {
            
            //hapus image lama
            Storage::disk('local')->delete('public/products/'.$product->image);

            //upload image baru
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            //update dengan image
            $product = Product::findOrFail($product->id);
            $product->update([
                'image'         => $image->hashName(),
                'title'         => $request->title,
                'slug'          => Str::slug($request->title, '-'),
                'category_id'   => $request->category_id,
                'content'       => $request->content,
                'unit'          => $request->unit,
                'wieght'        => $request->weight,
                'price'         => $request->price,
                'discount'      => $request->discount,
            ]);
        }
        if ($product) {
            return redirect()->route('admin.product.index')->with(['success' => 'Data Berhasil Di Simpan']);
        }else {
            return redirect()->route('admin.product.index')->with(['success' => 'Data Gagal Di Simpan']);
        }    
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $image = Storage::disk('local')->delete('public/products'.$product->image);
        $product->delete();
        
        if ($product) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
        
    }
}
