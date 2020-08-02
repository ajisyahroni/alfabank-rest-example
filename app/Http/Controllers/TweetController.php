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
        $data = Tweet::with('user')->orderBy('created_at', 'desc')->get();
        return response()->json([
            'status_code' => 200,
            'status' => 'OK',
            'message' => 'menampilkan data tweet',
            'data' => $data
        ]);
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
            $inserted_tweet = Tweet::create([
                'user_id' => $user_id,
                'tweet' => $request->tweet,
                'time' => Carbon::now()->diffForHumans()
            ]);
            return response()->json([
                'succes' => true,
                'status_code' => 201,
                'message' => 'berhasil',
                'user_id' => $user_id,
                'data' => $inserted_tweet
            ]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'gagal', 'error' => $th]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function show(Tweet $tweet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function edit(Tweet $tweet)
    {
        //
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
                    return response()->json(['error' => $validator->errors()], 401);
                }

                $tweet->tweet = $request->tweet;
                $tweet->save();
                return response()->json([
                    'success' => true,
                    'status' => 'OK',
                    'status_code' => 200,
                    'message' => 'berhasil mengupdate data tweet',
                    'data' => $tweet
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'status' => 'failed',
                    'status_code' => 400,
                    'message' => 'gagal, anda mengupdate tweet user lain',
                    'data' => $tweet
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'status' => 'failed',
                'status_code' => 400,
                'message' => 'tweet yang kamu cari enggak ada',
            ]);
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
                return response()->json([
                    'success' => true,
                    'status' => 'OK',
                    'status_code' => 200,
                    'message' => 'berhasil menghapus data tweet',
                    'data' => $tweet
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'status' => 'failed',
                    'status_code' => 400,
                    'message' => 'gagal, anda menghapus tweet user lain',
                    'data' => $tweet
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'status' => 'failed',
                'status_code' => 400,
                'message' => 'tweet yang kamu cari enggak ada',
            ]);
        }
    }
}
