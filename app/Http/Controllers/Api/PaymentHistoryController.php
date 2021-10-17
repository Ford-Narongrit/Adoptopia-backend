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
        $paymentHistory = $user->paymentHistories()->orderBy('created_at', 'desc')->paginate(10);
        
        return new PaymentHistoryCollection($paymentHistory);
    }

    public function store(Request $request)
    {
        $paymentHistory = new PaymentHistory();
        $user = JWTAuth::user();
        $status = $request->status;
        $amount = floatval($request->amount);
        if($amount && intval($amount) != $amount){
            $amount = $amount + 0;
        }
        else {
            $amount = number_format( (float) $request->amount, 2, '.', '');
        }
        
        if($request->trans_user){
            $trans_user = User::findOrFail($request->trans_user);
            $paymentHistory->trans_user = $trans_user->id;
            $paymentEarn = new PaymentHistory();
            $paymentEarn->status = 'earn';
            $paymentEarn->amount = $amount;
            $paymentEarn->user_id = $trans_user->id;
            $paymentEarn->trans_user = $user->id;
            $paymentEarn->save();
        }
        
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
