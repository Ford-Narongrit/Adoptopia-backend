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
        $this->middleware('auth:api', ['except' => ['searchByUsername']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return User[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {

        $user = User::where('username', '!=', 'Admin')->take(5)->get();
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        $owner = JWTAuth::user();
        $user = User::where('username', $slug)->with(['followers', 'following'])->first();
        if ($user->banned != null && $owner->role != 'ADMIN') {
            return response()->json(['error' => 'Banned'], 423);
        }
        if ($owner->id == $user->id) {
            $user->setAttribute('isOwner', true);
        } else {
            $user->setAttribute('isOwner', false);
        }
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

    public function earn(TopupRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules(), $request->messages());
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::findOrFail($request->id);
        $user->coin += $request->amount;
        $user->save();
        return $user;
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

    public function showOwner($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    public function searchByUsername(Request $request)
    {
        $user = User::where('username', '!=', 'Admin')->take(5)->get();
        if (!empty($request->username)) {
            $user = User::where([
                ['username', '!=', 'Admin'],
                ['username', 'like', $request->username . '%']
            ])->take(5)->get();
        }
        return $user;
    }

}
