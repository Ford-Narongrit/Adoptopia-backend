<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Tymon\JWTAuth\Facades\JWTAuth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = JWTAuth::user();
        $notifications = Notification::with(['user','trade'])->where('owner_id', $user->id)
                                    ->orderBy('created_at', 'desc')->take(20)->get();
        return $notifications;
    }

    public function store(Request $request)
    {
        $notification = new Notification();
        $notification->text = $request->text;
        $notification->user_id = $request->user_id;
        $notification->post_id = $request->post_id;
        $notification->save();

        return $notification;
    }

    public function show($id)
    {
        $notification = Notification::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        return $notification;
        return $notification;
    }

    public function update(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        if ($request->text !== null) {
            $notification->text = $request->text;
        }
        $notification->save();
        return $notification;
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
    }

    public function unseen(){
        $user = JWTAuth::user();
        $notifications = Notification::where([ ['owner_id', $user->id] , ['status' , 'unseen'] ])->get();
        return $notifications;
    }

    public function seen(){
        $user = JWTAuth::user();
        $notifications = Notification::where([ ['owner_id', $user->id] , ['status' , 'seen'] ])->get();
        return $notifications;
    }

    public function updateStatus(){
        $user = JWTAuth::user();
        $notifications = Notification::where([ ['owner_id', $user->id] , ['status' , 'unseen'] ])->get();
        $notifications->map(function ($notification){
            $notification->status = "seen";
            $notification->save();
        });
        return $notifications;
    }
}
