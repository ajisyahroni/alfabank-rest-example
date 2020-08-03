<?php

namespace App\Http\Controllers;

use App\Tweet;
use App\User;
use Validator;
use Faker\Generator as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * 
     * SHOW TWEET BY USER ID ON LOGIN
     * @return user with tweet
     */
    public function dashboard(Tweet $tweet)
    {
        $auth_id = Auth::id();
        $auth_user_tweet = User::where('id', '=', $auth_id)->with(['tweets' => function ($query) {
            return $query->orderBy('created_at', 'desc')->get();
        }])->first();
        return apiReturn($auth_user_tweet, 'mendapatkan data user dan tweet');
    }


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
            return apiUnauthorized('gagal login');
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
            return apiFailed([], 'gagal logout');
        }
    }
    public function register(Request $request, Faker $faker)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return apiValidate($errors);;
        }
        $check = User::where('email', '=', $request->email)->first();
        if ($check) {
            return apiFailed([], 'email sudah digunakan');
        }
        $vector_avatar = [
            'https://semantic-ui.com/images/avatar2/large/elyse.png',
            'https://semantic-ui.com/images/avatar2/large/matthew.png',
            'https://semantic-ui.com/images/avatar2/large/kristy.png',
            'https://semantic-ui.com/images/avatar2/large/molly.png',
            'https://semantic-ui.com/images/avatar/large/elliot.jpg',
            'https://semantic-ui.com/images/avatar/large/jenny.jpg',
            'https://semantic-ui.com/images/avatar/large/steve.jpg',
            'https://semantic-ui.com/images/avatar/large/daniel.jpg',
            'https://semantic-ui.com/images/avatar/large/helen.jpg',
            'https://semantic-ui.com/images/avatar/large/elliot.jpg',
            'https://semantic-ui.com/images/avatar/large/stevie.jpg',
            'https://semantic-ui.com/images/avatar/large/veronika.jpg'
        ];
        $input = $request->all();
        $input['username'] = $request->username ? $request->username : $faker->name();
        $input['avatar'] = $vector_avatar[rand(0, count($vector_avatar) - 1)];
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
