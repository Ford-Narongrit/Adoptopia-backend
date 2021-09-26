<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            if ($path) {
                return response()->json([
                    'message' => 'file uploaded',
                    'file' => $filename,
                    'path' => "/storage/{$dir}/{$filename}",
                    'size' => $fileSize,
                    'type' => $fileType
                ], 200);
            }
        }
        return response()->json(['message' => 'error uploading file'], 503);
    }
}
