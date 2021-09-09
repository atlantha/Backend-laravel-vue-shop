<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->when(request()->q, function($customers){
            $customers = $customers->where('name', 'like', '%', request()->q . '%');
        });

        return view('admin.customer.index', compact('customers'));
    }
}
