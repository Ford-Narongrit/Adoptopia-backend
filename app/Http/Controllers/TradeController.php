<?php

namespace App\Http\Controllers;

use App\Http\Requests\TradeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Trade;
use App\Models\Adopt;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class TradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trades = Trade::get();
        $trades->map(function ($trade) {
            return collect($trade->adopt
                ->load(['adopt_image', 'category']))
                ->all();
        });

        return $trades;
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
    public function store(TradeRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules(), $request->messages());
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $trades = new Trade();
        $user = JWTAuth::user();
        $trades->user_id = $user->id;
        $trades->adopt_id = $request->adopt_id;
        $trades->type = $request->type;
        $trades->status = $request->status;
        $trades->price = $request->price;

        $trades->save();
        return $trades;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $trade = Trade::findOrFail($id);
        return $trade;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $price)
    {
        $trades = Trade::findOrFail($id);
        $trades->price = $price;
        $trades->save();
        return $trades;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function close_sale($id)
    {
        $trades = Trade::findOrFail($id);
        $trades->status = "off";
        $trades->save();
        return $trades;
    }

    public function destroy($id)
    {
        $trades = Trade::findOrFail($id);
        $trades->delete();
    }

    public function userPost($slug)
    {
        $user = User::where('username', $slug)->first();
        $trades = Trade::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')->get();

        $trades->map(function ($trade) {
            $trade->load(['user']);
            $trade->adopt->load(['adopt_image', 'category']);
        });
        return $trades;

    }
}
