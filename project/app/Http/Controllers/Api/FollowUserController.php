<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FollowerUser;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class FollowUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
//if (!JWTAuth::user()->isAdmin()) {
//return response()->json(['error' => 'Only Admin'], 423);
//}
    public function follow($id)
    {
        $following = User::findOrFail($id);
        $follower = JWTAuth::user();
        if ($follower->id == $following->id)
            return response()->json(['error' => 'cannot following yourself'], 400);
        if ($following->banned || $following->role == 'ADMIN')
            return response()->json(['error' => 'cannot following this account'], 423);
        $followUser = FollowerUser::where(['following_id' => $following->id, 'follower_id' => $follower->id])->first();
        if ($followUser != null)
            return response()->json(['error' => 'already follow!'], 400);
        $followUser = FollowerUser::firstOrcreate([
            'follower_id' => $follower->id,
            'following_id' => $following->id,
            'accepted_at' => Carbon::now(),
        ]);

        // save notification
        $notification = new Notification();
        $notification->text = $follower->name." started following you.";
        $notification->owner_id = $following->id;
        $notification->user_id = $follower->id;
        $notification->trade_id = null;
        $notification->save();

        return $followUser;
    }

    public function unFollow($id)
    {
        $follower = JWTAuth::user();
        $following = User::findOrFail($id);
        $followerUser = FollowerUser::where(['follower_id' => $follower->id,
            'following_id' => $following->id,])->first();
        $followerUser->delete();
        return 'delete';
    }

    public function isFollow($id)
    {
        $following = User::findOrFail($id);
        $follower = JWTAuth::user();
        $isFollow = in_array($following->id, $follower->following->pluck('id')->toArray());
        return response()->json(['isFollow' => $isFollow], 200);
    }


}
