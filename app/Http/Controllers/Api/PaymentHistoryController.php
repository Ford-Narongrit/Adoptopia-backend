<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\PaymentHistoryResource;
use App\Http\Resources\PaymentHistoryCollection;

class PaymentHistoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }
    
    public function index()
    {
        $user = JWTAuth::user();
        
        $paymentHistory = $user->paymentHistories()->paginate(10);
        
        return new PaymentHistoryCollection($paymentHistory);
        // return response()->json($paymentHistory);
    }

    public function store(Request $request)
    {
        $paymentHistory = new PaymentHistory();
        $user = JWTAuth::user();
        // $paymentHistory->post_id = $request->post_id;
        $status = $request->status;
        $amount = floatval($request->amount);
        if($amount && intval($amount) != $amount){
            $amount = $amount + 0;
        }
        else {
            $amount = number_format( (float) $request->amount, 2, '.', '');
        }
        

        $paymentHistory->trans_user = $request->trans_user;
        $paymentHistory->status = $status;
        $paymentHistory->amount = $amount;
        $paymentHistory->user_id = $user->id;
        $paymentHistory->save();
    }

    public function destroy(PaymentHistory $paymentHistory)
    {
        //
    }
}
