<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdoptRequest;
use App\Http\Resources\AdoptResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Adopt;
use App\Models\AdoptImage;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
        $user = JWTAuth::user();
        $adopts = $user->adopt->load(['adopt_image', 'category']);
        return $adopts;
    }

    public function getAllUserAdop($slug)
    {
        $user = User::where('username', $slug)->first();
        $adopts = $user->adopt->load(['adopt_image', 'category']);
        return $adopts;
    }

    public function store(AdoptRequest $request)
    {

        $validator = Validator::make($request->all(), $request->rules(), $request->messages());
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $adopt = new Adopt();
        $adopt->name = $request->name;
        $adopt->agreement = $request->agreement;
        $user = JWTAuth::user();
        $adopt->user_id = $user->id;
        $adopt->status = 0;
        $catArr = [];


        foreach ($request->category as $cat) {
            $newCategory = Category::firstOrCreate(
                ['name' =>  trim($cat)]
            );
            array_push($catArr, $newCategory->id);
        }
        $adopt->save();
        // save in pivot table
        $adopt->category()->attach($catArr);


        $arrImage = [];
        if ($request->hasfile('images')) {
            foreach ($request->file('images') as $file) {
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
                array_push($arrImage, $adoptImage);
            }
        }

        return "Add adopt success";
    }

    public function show($id)
    {
        $user = JWTAuth::user();
        $adopt = $user->adopt->where('id', $id)->first();
        if ($adopt == null) {
            return response()->json([
                'message' => 'this is not the adopt you are looking for.',
            ], 404);
        }
        $adopt->load(['adopt_image', 'category']);
        return $adopt;
    }

    public function update(Request $request, $id)
    {
        $adopt = Adopt::findOrFail($id);
        if ($request->image !== null) {
            $adopt->image = $request->image;
        }
        if ($request->name !== null) {
            $adopt->name = $request->name;
        }
        if ($request->agreement !== null) {
            $adopt->agreement = $request->agreement;
        }
        $adopt->save();
        return $adopt;
    }

    public function transfer($id, $transfer_id){
        $adopt = Adopt::findOrFail($id);
        $adopt->user_id = $transfer_id;
        $adopt->save();
    }

    public function inUse($id){
        $adopt = Adopt::findOrFail($id);
        $adopt->status = 1;
        $adopt->save();
    }

    public function unUse($id){
        $adopt = Adopt::findOrFail($id);
        $adopt->status = 0;
        $adopt->save();
    }

    public function destroy($id)
    {
        $adopt = Adopt::findOrFail($id);
        $adopt->delete();
    }
}
