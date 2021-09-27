<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{

    public function index()
    {
        $notifications = Notification::with('user')->get();
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
        $notification = Notification::with('user')->where('id', $id)->get();
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
}
