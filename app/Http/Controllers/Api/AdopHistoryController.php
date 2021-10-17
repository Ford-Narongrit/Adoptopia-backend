<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdopHistory;
use App\Models\User;
use App\Models\Adopt;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\AdopHistoryResource;
use App\Http\Resources\AdopHistoryCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\HistorySearchRequest;

class AdopHistoryController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = JWTAuth::user();
        $adopHistory = $user->adopHistories()->orderBy('created_at', 'desc')->paginate(10);
        
        return new AdopHistoryCollection($adopHistory);
    }

    public function store(Request $request)
    {
        $user = JWTAuth::user();
        $adopHistory = new AdopHistory();
        $adopHistory->status = $request->status;
        $adopHistory->user_id = $user->id;
        $trans_user = User::findOrFail($request->trans_user);
        if(!$trans_user)
            return response()->json(['error' => 'User not found'], 404);
        $adopHistory->trans_user = $trans_user->id;

        $adopt = Adopt::findOrFail($request->adopt_id);
        if(!$adopt)
            return response()->json(['error' => 'Adop not found'], 404);
        $adopHistory->adopt_id = $adopt->id;

        $adopHistory2 = new AdopHistory();
        $adopHistory2->status = $request->status;
        $adopHistory2->user_id = $trans_user->id;
        $adopHistory2->trans_user = $user->id;
        $adopHistory2->trans_adopt = $adopt->id;

        if($request->status == 'OTA'){
            $trans_adopt = Adopt::findOrFail($request->trans_adopt);
            if(!$trans_adopt) 
                return response()->json(['error' => 'Adop not found'], 404);
            $adopHistory->trans_adopt = $trans_adopt->id;
            $adopHistory2->adopt_id = $trans_adopt->id;
    
        }
        $adopHistory->save();
        $adopHistory2->save();
    }

    public function search(HistorySearchRequest $request) {

        $validator = Validator::make($request->all(), $request->rules(), $request->messages());
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $dateFrom = new Carbon($request->dateFrom);
        $dateTo = Carbon::createFromFormat('Y-m-d', $request->dateTo)->endOfDay()->toDateTimeString();
        $user = JWTAuth::user();
        if($request->status != 'All') {
            $status = $request->status;
            $adopHistory = $user->adopHistories()->where('status', '=', $status)
                                ->whereBetween('created_at', [$dateFrom, $dateTo])
                                ->orderBy('created_at', 'desc')->paginate(10);
        }
        else {
            $adopHistory = $user->adopHistories()
                                ->whereBetween('created_at', [$dateFrom, $dateTo])
                                ->orderBy('created_at', 'desc')->paginate(10);
        }
        return new AdopHistoryCollection($adopHistory);
    }

    public function destroy(AdopHistory $adopHistory)
    {
        //
    }
}
