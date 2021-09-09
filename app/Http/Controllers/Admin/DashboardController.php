<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index(){
        $pending = Invoice::where('status', 'pending')->count();
        $success = Invoice::where('status', 'success')->count();
        $expired = Invoice::where('status', 'expired')->count();
        $failed = Invoice::where('status', 'failed')->count();

        $year = date('Y');
        $month = date('m');

        $revenueMonth = Invoice::where('status', 'success')->whereMonth('created_at', '*', $month)->whereYear('created_at', $year)->sum('grand_total');
        $revenueYear = Invoice::where('status', 'success')->whereYear('created_at', $year)->sum('grand_total');
        $revenueAll = Invoice::where('status', 'success')->sum('grand_total');

        return view('admin.dashboard.index', compact('pending', 'success', 'expired', 'failed', 'revenueMonth', 'revenueYear', 'revenueAll'));
    }
}
