<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adopt;
use App\Models\AdoptImage;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdoptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $adopts = Adopt::all();
        return $adopts;
    }

    public function store(Request $request)
    {
        
        $adopt = new Adopt();
        $adopt->name = $request->name;
        $adopt->agreement = $request->agreement;
        $user = JWTAuth::user();
        $adopt->user_id = $user->id;
        $catArr = [];

        foreach($request->category as $category_id){
            array_push($catArr , $category_id);
        }
        $adopt->save();
        // save in pivot table
        $adopt->category()->attach($catArr);


        $arrImage = [];
        if($request->hasfile('images')){
            foreach($request->file('images') as $file){
                $adoptImage = new AdoptImage();
                $adoptImage->adopt_id = $adopt->id;
                $filename = $file->getClientOriginalName();
                $filename = time() . '-' . str_replace(' ', '', $filename);
                $path = $file->storeAs("public/adopts", $filename);
                $adoptImage->path = "/storage/adopts/{$filename}";
                $fileType = $file->getClientMimeType();
                $adoptImage->type = $fileType;
                $fileSize = Storage::size($path);
                $adoptImage->size = $fileSize;
                $width = Image::make($file->getRealPath())->width();
                $adoptImage->width = $width;
                $height = Image::make($file->getRealPath())->height();
                $adoptImage->height = $height;
                $adoptImage->save();
                array_push($arrImage , $adoptImage);
            }
        }

        return "Add adopt success";
    }

    public function show($id)
    {
        $adopt = Adopt::findOrFail($id);
        return $adopt;
    }

    public function update(Request $request, $id)
    {
        $adopt = Adopt::findOrFail($id);
        if ($request->image !== null){
            $adopt->image = $request->image;
        }
        if($request->name !== null){
            $adopt->name = $request->name;
        }
        if($request->agreement !== null){
            $adopt->agreement = $request->agreement;
        }
        $adopt->save();
        return $adopt;
    }

    public function destroy($id)
    {
        $adopt = Adopt::findOrFail($id);
        $adopt->delete();
    }
}