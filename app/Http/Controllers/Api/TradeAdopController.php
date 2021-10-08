<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TradeAdop;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TradeAdopController extends Controller
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
        $user = JWTAuth::user();
        $trade_adops = $user->trade_adops();
        return $trade_adops;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $trade_adops = new TradeAdop();

        $user = JWTAuth::user();
        $trade_adops->user_id = $user->id;
        $trade_adops->adopt_id = $request->adopt_id;
        $trade_adops->type = $request->type;
        $trade_adops->status = $request->status;
        
        $trade_adops->save();
        return $trade_adops;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TradeAdop  $tradeAdop
     * @return \Illuminate\Http\Response
     */
    public function show(TradeAdop $tradeAdop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TradeAdop  $tradeAdop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TradeAdop $tradeAdop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TradeAdop  $tradeAdop
     * @return \Illuminate\Http\Response
     */
    public function destroy(TradeAdop $tradeAdop)
    {
        //
    }
}
