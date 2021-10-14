<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopupRequest;
use App\Http\Requests\WithdrawRequest;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //create in Auth register
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Responsep
     */
    public function update(Request $request, $id)
    {
        //update in Auth update
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = JWTAuth::user();
        $user->delete();
    }

    public function deposit(TopupRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules(), $request->messages());
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = JWTAuth::user();
        $user->coin += $request->amount;
        $user->save();
        return $user;
    }
    // public function withdraw($id, $amount)
    // {   
    //     $user = User::findOrFail($id);
    //     if (!is_numeric($amount)) {
    //         return response()->json("Invalid amount", 422);
    //     } else if ($amount <= 0) {
    //         return response()->json("Amount should be at least 1", 422);
    //     } else if ($amount > $user->coin) {
    //         return response()->json("You don't have enough coin", 422);
    //     }
    //     $user->coin -= $amount;
    //     $user->save();
    //     return $user;
    // }
    public function spend($id, $amount)
    {
        $user = User::findOrFail($id);
        if (!is_numeric($amount)) {
            return response()->json("Invalid amount", 422);
        } else if ($amount <= 0) {
            return response()->json("Amount should be at least 1", 422);
        } else if ($amount > $user->coin) {
            return response()->json("You don't have enough coin", 422);
        }
    }
    public function withdraw(WithdrawRequest $request)
    {
        $user = JWTAuth::user();
        $validator = Validator::make($request->all(), $request->rules(), $request->messages());
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $user->coin -= $request->amount;
        $user->save();
        return $user;
    }
    public function notification($id)
    {
        $user = Notification::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        return $user;
    }
}
