<?php

namespace App\Http\Controllers\Admin;

use App\Models\ReportUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class ReportUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (!JWTAuth::user()->isAdmin()) {
            return response()->json(['error' => 'Only Admin'], 423);
        }
        return ReportUser::with(['reportBy', 'user'])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return ReportUser|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $reported_by = JWTAuth::user();
        $user_id = $request->user_id;
        if ($reported_by->id == $user_id)
            return response()->json(['error' => 'cannot report yourself'], 400);
        $report = new ReportUser();
        $report->reported_by = $reported_by->id;
        $report->user_id = $user_id;
        $report->description = $request->description;
        $report->save();
        return $report;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ReportUser $reportUser
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        if (!JWTAuth::user()->isAdmin()) {
            return response()->json(['error' => 'Only Admin'], 423);
        }
        return ReportUser::with(['reportBy', 'user'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReportUser $reportUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportUser $reportUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ReportUser $reportUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportUser $reportUser)
    {
        //
    }
}
