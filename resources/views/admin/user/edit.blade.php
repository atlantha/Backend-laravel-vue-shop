@extends('layouts.app', ['title' => 'Edit User'])

@section('content')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold"><i class="fa fa-shopping-bag"></i>EDIT USER</h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NAMA</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" placeholder="Masukkan nama user" class="form-control @error('name') is-invalid @enderror">
        
                                    @error('name')
                                    <div class="invalid-feedback" style="display:block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="fomr-group">
                                    <label>EMAIL</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"  value="{{ old('email', $user->email) }}" placeholder="masukkan email">

                                    
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>PASSWORD</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="masukkan password">

                                    @error('password')
                                        <div class="invalid-feedback" style="display: block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>CONFIRM PASSWORD</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="masukkan konfirmasi password">
                                </div>
                            </div>
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>SIMPAN</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i>RESET</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    var edito_config = {
        selector: 'textarea.content',
        plugins: [
            "advlist autolink list link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visulachars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls: false,
    };
    tinymce.init(editor_config)
</script>
@endsection