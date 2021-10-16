<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class BanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function userBan()
    {
        if (!JWTAuth::user()->isAdmin()) {
            return response()->json(['error' => 'Only Admin'], 423);
        }
        $user = User::where('banned', '!=', null)->get();
        return $user;
    }

    public function ban(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!JWTAuth::user()->isAdmin()) {
            return response()->json(['error' => 'Only Admin'], 423);
        }
        $user = User::findOrFail($request->id);
        $user->banned = Carbon::now();
        $user->save();
        return $user;
    }

    public function unban(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!JWTAuth::user()->isAdmin()) {
            return response()->json(['error' => 'Only Admin'], 423);
        }
        $user = User::findOrFail($request->id);
        $user->banned = null;
        $user->save();
        return $user;
    }
}
