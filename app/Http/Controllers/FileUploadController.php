<?php

namespace App\Http\Controllers;

use App\Services\FileUploadService;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function __construct(private FileUploadService $fileUploadService) {}

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'required|in:facility,user,review,payment_proof'
        ]);

        try {
            $result = $this->fileUploadService->uploadImage(
                $request->file('file'),
                $request->type
            );

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function deleteImage(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);

        try {
            $result = $this->fileUploadService->deleteImage($request->path);
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
