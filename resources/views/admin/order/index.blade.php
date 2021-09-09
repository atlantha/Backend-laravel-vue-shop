@extends('layouts.app', ['title' => 'Orders'])

@section('content')

<div class="container-fluid mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fa fa-shopping-cart"></i>ORDERS</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.order.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="q" placeholder="Cari Berdasarkan No invoice">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>CARI</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                    <th scope="col">NO INVOICE</th>
                                    <th scope="col">NAMA LENGKAP</th>
                                    <th scope="col">GRAND TOTAL</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col" style="text-align: center;width: 15%">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $no => $invoice)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no + ($invoices->currentPage()-1) * $invoices->perPage() }}</th>
                                    <td class="text-center">
                                        {{ $invoice->invoice }}
                                    </td>
                                    <td>{{ $invoice->name }}</td>
                                    <td class="text-center">{{ $invoice->status }}</td>
                                    <td>{{ moneyFormat($invoice->grand_total) }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.order.show', $order->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-list-ul"></i></a>
                                    </td>
                                </tr>
                                @empty

                                    <div class="alert alert-danger">
                                        Data Belum Tersedia!
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        <div style="text-align: center">
                            {{ $invoices->links("vendor.pagination.bootstrap-4") }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>hay</h1>
</body>
</html> --}}