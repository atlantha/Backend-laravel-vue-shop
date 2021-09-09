<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/assets/img/company.img') }}" type="image/x-icon">
    <title>{{ $title ?? config('app.name') }} - Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/assets/vendor/fontawesome-free/css/all.min.css') }}" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family:Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="{{ asset('assets/assets/css/sb-admin-2.min.css') }}">
</head>
<body style="background-color: #ffd600">

    @yield('content')

<script src="{{ asset('assets/assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<script src="{{ asset('assets/assets/js/sb-admin-2.min.js') }}"></script>
    
</body>
</html>