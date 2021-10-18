<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadFileController extends Controller
{
    public function store(Request $request, $dir)
    {
        if ($request->file('file')) {
            $file = $request->file('file');
            //$fileSize = $file->getSize();
            $filename = $file->getClientOriginalName();
            $filename = time() . '-' . str_replace(' ', '', $filename);
            $path = $file->storeAs("public/{$dir}", $filename);
            $fileType = $file->getClientMimeType();
            $fileSize = Storage::size($path);
            $imgFile = Image::make($file->getRealPath());
            if ($path) {
                return response()->json([
                    'message' => 'file uploaded',
                    'filename' => $filename,
                    'path' => "/storage/{$dir}/{$filename}",
                    'size' => $fileSize,
                    'type' => $fileType,
                    'heigh' => $imgFile->height(),
                    'width' => $imgFile->width()
                ], 200);
            }
        }
        return response()->json(['message' => 'error uploading file'], 503);
    }
}
