<?php

namespace App\Http\Controllers;

use App\Tweet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;
use Validator;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $tweets_users = Tweet::with('user')->orderBy('created_at', 'desc')->get();
            return apiReturn($tweets_users, 'menampilkan data tweet');
        } catch (\Throwable $th) {
            return apiCatch();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $user_id = Auth::id();
            $validator = Validator::make($request->all(), [
                'tweet' => 'required'
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return apiValidate($errors);
            }

            $inserted_tweet = Tweet::create([
                'user_id' => $user_id,
                'tweet' => $request->tweet,
                'time' => Carbon::now()->diffForHumans()
            ]);
            return apiCreated($inserted_tweet, 'berhasil membuat tweet');
        } catch (\Throwable $th) {
            return apiCatch();
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tweet = Tweet::find($id);
        if ($tweet) {
            if ($tweet->user_id == Auth::id()) {
                $validator = Validator::make($request->all(), [
                    'tweet' => 'required'
                ]);
                if ($validator->fails()) {
                    $errors = $validator->errors();
                    return apiValidate($errors);
                }

                $tweet->tweet = $request->tweet;
                $tweet->save();
                return apiReturn($tweet, 'berhasil update tweet');
            } else {
                return apiFailed($tweet, 'gagal, anda mencoba mengupdate tweet user lain');
            }
        } else {
            return apiFailed([], 'tweet yang kamu cari tidak ada');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tweet = Tweet::find($id);
        if ($tweet) {
            if ($tweet->user_id == Auth::id()) {
                $tweet->delete();
                return apiReturn($tweet, 'berhasil menghapus tweet anda');
            } else {
                return  apiFailed($tweet, 'gagal, anda mencoba menghapus tweet user lain');
            }
        } else {
            return apiFailed([], 'tweet yang kamu cari tidak ada');
        }
    }
}
