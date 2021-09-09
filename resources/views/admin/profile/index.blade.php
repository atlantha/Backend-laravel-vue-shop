@extends('layouts.app', ['title' => 'Profile'])
@section('content')
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            @if (session('status') == 'profile-information-updated')
                                Profile has been updated
                            @endif
                            @if (session('status') == 'password-updated')
                                Profile has been updated
                            @endif
                            @if (session('status') == 'two-factor-authentication-disabled')
                                Two factor authentication disabled
                            @endif
                            @if (session('status') == 'two-factor-authentication-enabled')
                            Two factor authentication enabled
                            @endif
                            @if (session('status') == 'recovery-codes-generated')
                                Recovery codes generated
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::twoFactorAuthentication()))
                <div class="col-md-5 mb-5">
                    <div class="card border-0 shadow">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold"><i class="fas fa-key"></i>Two-Factor Authentication</h6>
                        </div>

                        <div class="card-body">
                            @if (! auth()->user('two_factor_secret'))
                            <form action="{{ url('user/two-factor-authentication') }}" method="POST">
                                @csrf

                                <button type="submit" class="btn btn-primary text-uppercase">
                                    Enable Two-Factor
                                </button>
                            </form>
                            @else
                            <form action="{{ url('user/two-factor-authentication') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-primary text-uppercase">
                                    Disable Two-Factor
                                </button>
                            </form>

                            @if(session('status') == 'two-factor-authentication-enabled')
                            <p>
                                otentikasi dua faktor sekarang diaktifkan. pindai kode QR berikut menggunakan aplikasi pengautentikasi ponsel
                            </p>

                            <div class="mv-3">
                                {!! auth()->user()->twoFactorQrCodeSvg() !!}
                            </div>
                            @endif

                            <p>
                                Simpan recovery code ini dengan aman. Ini dapat digunakan untuk memulihkan akses ke akun anda jika perangkat
                            </p>

                            <div style="background: rgb(44, 44, 44); color:white" class="rounded p-3 mb-2">
                                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                    <div>{{ $code }}</div>
                                @endforeach
                            </div>

                            <form action="{{ url('user/two-factor-recovery-codes') }}">
                                @csrf

                                <button type="submit" class="btn btn-dark tex-uppercase">
                                    Regenerate recovery codes
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-7">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-user-circle"></i>Edit Profile</h6>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('user-profile-information.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="text-uppercase">Nama</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') ?? auth()->user('name') }}" required autofocus autocomplete="name">
                            </div>

                            <div class="form-group">
                                <label class="text-uppercase">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') ?? auth()->user('email') }}" required autofocus>
                            </div>
                            
                            <div class="form-group">
                                <button class="btn btn-primary text-uppercase" type="submit">
                                    Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

               <div class="card border-0 shadow mt-3 mb-4">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-unlock"></i>Update Password</h6>             
                    </div>
                    
                    <div class="card-body">
                        <form action="{{ route('user-password.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="text-uppercase">Current Password</label>
                                <input type="password" class="form-control" name="current_password" required autocomplete="current-password">
                            </div>

                            <div class="form-group">
                                <label class="text-uppercase">Password</label>
                                <input type="password" class="form-control" name="password" required autocomplete="new-password">
                            </div>

                            <div class="form-group">
                                <label class="text-uppercase">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary text-uppercase">
                                    update password
                                </button>
                            </div>
                        </form>
                    </div>
               </div> 
            </div>
        </div>
    </div>

@endsection