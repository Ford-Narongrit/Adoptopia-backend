<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TradeAdop;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

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
        $trades = TradeAdop::get();
        $trade_adops = $trades->map(function ($trade){
            return collect($trade->adopt
            ->load(['adopt_image', 'category']))
            ->all();
        });

        return $trade_adops;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trade_adops = TradeAdop::findOrFail($id);
        return $trade_adops;
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
        $trade_adops = TradeAdop::findOrFail($id);
        $trade_adops->delete();
    }
}
