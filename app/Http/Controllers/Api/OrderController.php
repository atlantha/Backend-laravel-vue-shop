<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class OrderController extends Controller
{
    public function __construct()
    {
        $invoices = Invoice::where('customer_id', auth()->guard('api')->user()->id->latest()->get());

        return response()->json([
            'success'   => true,
            'message'   => 'List Invoices: '.auth()->guard('api')->user()->name,
            'data'      => $invoices
        ], 200);
    }

    public function show($snap_token)
    {
        $invoice = Invoice::where('customer_id', auth()->guard('api')->user()->id)->where('snap_token', $snap_token)->latest()->first();

        return response()->json([
            'success'       => true,
            'message'       => 'Detail Invoices: '.auth()->guard('api')->user()->name,
            'data'          => $invoice,
            'product'       => $invoice->orders
        ], 200);
    }
}
