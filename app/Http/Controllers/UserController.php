<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$user = User::findOrFail($id);
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
        $user = User::findOrFail($id);
        // $this->authorize('update', $user);

        // $request->validate([
        //     'name' => ['required'],
        //     'email' => ['required', 'email', "unique:users,email,{$id}"]
        // ]);
        if ($request->name !== null) {
            $user->name = $request->name;
        }
        if ($request->username !== null) {
            $user->username = $request->username;
        }
        if ($request->password !== null) {
            $user->password = Hash::make($request->password);
        }
        if ($request->email !== null) {
            $user->email = $request->email;
        }
        if ($request->description !== null) {
            $user->description = $request->description;
        }
        // if ($user->profile != null) {
        //    $user->profile = $request->profile;
        // }
        $user->save();

        return $user;
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

    public function topup($id, $amount)
    {
        if ($amount < 0) {
            return "Invalid amount";
        }
        $user = User::findOrFail($id);
        $user->coin += $amount;
        $user->save();
        return $user;
    }

    public function notification($id){
        $user = Notification::where('user_id', $id)->orderBy('created_at' , 'desc')->get();
        return $user;
    }
}
