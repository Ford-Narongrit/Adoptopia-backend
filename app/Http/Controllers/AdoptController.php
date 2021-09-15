<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Adopt;

class AdoptController extends Controller
{

    //TODO catagory
    public function index()
    {
        $adopts = Adopt::all();
        return $adopts;
    }

    public function store(Request $request)
    {
        $adopt = new Adopt();
        $adopt->image = $request->image;
        $adopt->name = $request->name;
        $adopt->agreement = $request->agreement;
        $adopt->user = $request->user;
        $adopt->category = 1;
        $adopt->save();

        return $adopt;
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
