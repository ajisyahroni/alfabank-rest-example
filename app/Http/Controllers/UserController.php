<?php

namespace App\Http\Controllers;

use App\User;
use Validator;
use Faker\Generator as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credential = $request->only(['email', 'password']);
        if (Auth::attempt($credential)) {
            $user = Auth::user();
            $success['user'] = $user;
            $success['token'] =  $user->createToken('nApp')->accessToken;
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => 'OK',
                'credential' => $success
            ]);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            Auth::user()->AauthAcessToken()->delete();
            return response()->json([
                'sucess' => true,
                'status_code' => 200,
                'status' => "OK",
                'message' => 'berhasil logout',
                'credential' => $user
            ]);
        } else {
            return response()->json([
                'succes' => false,
                'status' => "failed",
                'status_code' => 400,
                'message' => 'kami tidak mengenali anda'
            ]);
        }
    }
    public function register(Request $request, Faker $faker)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $check = User::where('email', '=', $request->email)->first();
        if ($check) {
            return response()->json([
                'success' => false,
                'status_code' => 400,
                'status' => 'failed',
                'message' => 'email sudah digunakan'
            ]);
        }
        $input = $request->all();
        $input['username'] = $request->username ? $request->username : $faker->name();
        $input['password'] = bcrypt($request->password);
        $user = User::create($input);
        $success['user'] = $user;
        $success['token'] =  $user->createToken('nApp')->accessToken;

        return response()->json([
            'success' => true,
            'status_code' => 201,
            'status' => 'created',
            'credential' => $success
        ]);
    }
}
