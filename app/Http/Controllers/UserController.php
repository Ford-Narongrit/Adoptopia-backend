<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

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
        $user = User::findOrFail($id);
        // $this->authorize('delete', $user);
        $user->delete();
    }

    public function deposit($id, $amount)
    {
        if ($amount < 0) {
            return "Invalid amount";
        }
        $user = User::findOrFail($id);
        $user->coin += $amount;
        $user->save();
        return $user;
    }
    public function withdraw($id, $amount)
    {
        $user = User::findOrFail($id);
        if ($amount > $user->coin) {
            return "You have not enough coin";
        }
        $user->coin -= $amount;
        $user->save();
        return $user;
    }

    public function notification($id)
    {
        $user = Notification::where('user_id', $id)->orderBy('created_at', 'desc')->get();
        return $user;
    }
}
