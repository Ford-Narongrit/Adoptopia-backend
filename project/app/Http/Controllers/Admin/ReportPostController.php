<?php

namespace App\Http\Controllers\Admin;

use App\Models\ReportPost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReportPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index()
    {
        if (!JWTAuth::user()->isAdmin()) {
            return response()->json(['error' => 'Only Admin'], 423);
        }
        $reportPost = ReportPost::with(['reportBy', 'post'])->get();
        $reportPost->map(function ($trade) {
            $trade->post->load(['adopt']);
        });
        return $reportPost;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return ReportPost|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'post_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $reported_by = JWTAuth::user();
        $post_id = $request->post_id;
        $report = new ReportPost();
        $report->reported_by = $reported_by->id;
        $report->post_id = $post_id;
        $report->description = $request->description;
        $report->save();
        return $report;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ReportPost $reportPost
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!JWTAuth::user()->isAdmin()) {
            return response()->json(['error' => 'Only Admin'], 423);
        }
        return ReportPost::with(['reportBy', 'post'])->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ReportPost $reportPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReportPost $reportPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ReportPost $reportPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReportPost $reportPost)
    {
        //
    }
}
