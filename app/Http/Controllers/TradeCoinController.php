<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TradeCoin;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TradeCoinController extends Controller
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
        $trades = TradeCoin::get();
        $trade_coins = $trades->map(function ($trade){
            return collect($trade->adopt
            ->load(['adopt_image', 'category']))
            ->all();
        });

        return $trade_coins;
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
        $trade_coins = new TradeCoin();
        $user = JWTAuth::user();
        $trade_coins->user_id = $user->id;
        $trade_coins->adopt_id = $request->adopt_id;
        $trade_coins->type = $request->type;
        $trade_coins->status = $request->status;

        $trade_coins->end_bit = $request->end_bit;
        $trade_coins->last_time = $request->last_time;

        $trade_coins->each_bit = $request->each_bit;
        $trade_coins->auto_buy = $request->auto_buy;
        $trade_coins->start_price = $request->start_price;
        $trade_coins->end_price = $request->end_price;

        $trade_coins->save();
        return $trade_coins;
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
