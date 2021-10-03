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
        //
    }

    public function destroy(PaymentHistory $paymentHistory)
    {
        //
    }
}
