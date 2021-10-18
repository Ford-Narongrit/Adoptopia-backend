<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OtaSug;
use App\Models\Adopt;
use App\Models\Notification;
use App\Models\Trade;
use Tymon\JWTAuth\Facades\JWTAuth;

class OtaSugController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ota_sugs = OtaSug::get();
        $ota_sugs->map(function ($ota_sug){
            return collect($ota_sug->adopt
            ->load(['adopt_image', 'category']))
            ->all();
        });

        return $ota_sugs;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ota_sugs = new OtaSug();
        $ota_sugs->trade_id = $request->trade_id;
        $user = JWTAuth::user();
        $ota_sugs->user_id = $user->id;
        $ota_sugs->adopt_id = $request->adopt_id;
        $ota_sugs->status = $request->status;
        $ota_sugs->save();

        $trade = Trade::with('adopt')->findOrFail($request->trade_id);

        // save notification
        $notification = new Notification();
        $notification->text = $user->name." send request to your ".$trade->adopt->name." adop (OTA) nakab";
        $notification->owner_id = $trade->user_id;
        $notification->user_id = $user->id;
        $notification->trade_id = $request->trade_id;
        $notification->save();


        return $ota_sugs;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
