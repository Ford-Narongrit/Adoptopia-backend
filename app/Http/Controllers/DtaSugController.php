<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DtaSug;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class DtaSugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = JWTAuth::user();
        $dta_sugs = user()->dta_sugs()->get();
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
        $dta_sugs = new DtaSug();
        $dta_sugs->trade_id = $request->trade_id;
        $user = JWTAuth::user();
        $dta_sugs->user_id = $user->id;
        $dta_sugs->status = $request->status;

        $filename = $file->getClientOriginalName();
        $filename = time() . '-' . str_replace(' ', '', $filename);
        $path = $file->storeAs("public/dta_sugs", $filename);
        $dta_sugs->path = "/storage/dta_sugs/{$filename}";
        $fileSize = Storage::size($path);
        $dta_sugs->size = $fileSize;
        $width = Image::make($file->getRealPath())->width();
        $dta_sugs->width = $width;
        $height = Image::make($file->getRealPath())->height();
        $dta_sugs->height = $height;
        
        $dta_sugs->save();
        return $dta_sugs;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dta_sugs = DtaSug::findOrFail($id);
        return $dta_sugs;
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
        $dta_sugs = DtaSug::findOrFail($id);
        $dta_sugs->delete();
    }
}
