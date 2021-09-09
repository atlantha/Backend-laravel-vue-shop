<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Customer;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['register', 'login']);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:225',
            'email'     => 'required|email|unique:customers',
            'password'  => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $customer = Customer::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($customer);

        if ($customer) {
            return response()->json([
                'success'   => true,
                'user'      => $customer,
                'token'     => $token
            ], 201);
        }

        return response()->json([
            'success'   => false,
        ], 409);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('email', 'password');
        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'success'   => false,
                'message'   => 'Email or password is incorrect'
            ], 401);
        }

        return response()->json([
            'success'       => true,
            'user'          => auth()->guard('api')->user(),
            'token'         => $token
        ], 201);
    }

    public function getUser()
    {
        return response()->json([
            'success'   => true,
            'user'      => auth()->user(),
        ], 200);
    }
}
