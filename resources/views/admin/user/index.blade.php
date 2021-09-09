@extends('layouts.app', ['title' => 'Product'])

@section('content')

<div class="container-fluid mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fa fa-shopping-bag"></i>PRODUK</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.user.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <a href="{{ route('admin.user.create') }}" class="btn btn-primary btn-sm" style="padding-top: 10px;"><i class="fa fa-plus-circle"></i>TAMBAH</a>
                                </div>
                                <input type="text" class="form-control" name="q" placeholder="Cari Berdasarkan Nama Produk">
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
                                    <th scope="col">NAMA User</th>
                                    <th scope="col">EMAIL</th>
                                    <th scope="col" style="text-align: center;width: 15%">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $no => $user)
                                <tr>
                                    <th scope="row" style="text-align: center">{{ ++$no + ($users->currentPage()-1) * $users->perPage() }}</th>
                                    <td class="text-center">
                                        {{ $user->name }}
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.user.edit', $product->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i></a>

                                        <button onclick="Delete(this.id)" class="btn btn-sm btn-danger" id="{{ $product->id }}"><i class="fa fa-trash"></i></button>
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
                            {{-- {{ ("vendor.pagination.bootstrap-4") }} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function Delete(id){
        var id = id;
        var token = $("meta[name='csrf-token']").attr("content");

        swal({
            title: "APAKAH KAMU YAKIN?",
            text: "INGIN MENGHAPUS DATA INI!",
            icon: "warning",
            buttons: [
                'TIDAK',
                'YA'
            ],
            dangerMode: true,
        }).then(function(isConfirm){
            if(isConfirm){

                jQuery.ajax({
                    url: "{{ route("admin.product.index") }}/" + id,
                    data: {
                        "id": id,
                        "_token": token
                    },
                    type: "DELETE",

                    success: function(response){
                        if(response.status == "success"){
                            swal({
                                title: 'BERHASIL!',
                                text: 'DATA BERHASIL DIHAPUS!',
                                icon: 'success',
                                timer: 1000,
                                showConfirmButton: false,
                                showCancelButton: false,
                                buttons: false,
                            }).then(function(){
                                location.reload();
                            });
                        }else{
                            swal({
                                title: 'GAGAL!',
                                text: 'DATA GAGAL DIHAPUS!',
                                icon: 'error',
                                timer: 1000,
                                showConfirmButton: false,
                                showCancelButton: false,
                                buttons: false,
                            }).then(function(){
                                location.reload();
                            });
                        }
                    }
                });
            }else{
                return true;
            }
        })
    }
</script>
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