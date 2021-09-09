<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    public function __construct()
    {   
        $this->middleware('auth:api');
    }

    public function index()
    {
        $carts = Cart::with('product')->where('customer_id', auth()->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json([
            'success'       => true,
            'message'       => 'list data cart',
            'cart'          => $carts
        ]);
    }

    public function store(Request $request){
        $item = Cart::where('product_id', $request->product_id)->where('customer_id', $request->customer_id);

        if ($item->count()) {
            $item->increment('quantity');
            $item = $item->first();

            $price = $request->price * $item->quantity;
            $weight = $request->weight * $item->quantity;
            $item->update([
                'price' => $price,
                'weight'   => $weight
            ]);
        }else {
            $item = Cart::create([
                'product_id'    => $request->product_id,
                'customer_id'   => $request->customer_id,
                'quantity'      => $request->quantity,
                'price'         => $request->price,
                'weight'        => $request->weight
            ]);
        }

        return response()->json([
            'success'       => true,
            'message'       => 'success add to cart',
            'quantity'      => $item->quantity,
            'product'       => $item->product
        ]);
    }

    public function getCartTotalWeight(){
        $carts = Cart::with('product')->where('customer_id', auth()->user()->id)->orderBy('created_at', 'desc')->sum('weight');
        return response()->json([
            'success'       => true,
            'message'       => 'Total cart weight',
            'total'         => $carts
        ]);
    }

    public function removeCart(Request $request){
        Cart::with('product')->whereId($request->cart_id)->delete();
        return response()->json([
            'success'       => true,
            'message'       => 'Remove cart item'
        ]);
    }

    public function removeAllCart(Request $request){
        Cart::with('product')->where('customer_id', auth()->guard('api')->user()->id);
        return response()->json([
            'success'       => true,
            'message'       => 'Remove all item in cart'
        ]);
    }
}
