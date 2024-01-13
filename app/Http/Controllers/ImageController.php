<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;


class ImageController extends Controller
{
    
    
    public function uploadImages(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'titles' => 'required|max:255',
        ]);
    
        $images = $request->file('images');
        $titles = $request->input('titles');
    
        if (!is_array($images) || !is_array($titles) || count($images) !== count($titles)) {
            return response()->json(['error' => 'Invalid images or titles data'], 400);
        }
    
        try {
            $user = User::findOrFail($request->user_id);
    
            $uploadedImages = [];
    
            DB::beginTransaction();
    
            foreach ($images as $key => $image) {
                $path = $image->storeAs('images', uniqid().'.'.$image->getClientOriginalExtension());
                $title = $titles[$key];
    
                $uploadedImages[] = $user->images()->create(['file_path' => $path, 'title' => $title])->id;
            }
    
            DB::commit();
    
            return response()->json(['message' => 'Images uploaded successfully', 'image_ids' => $uploadedImages], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error uploading images: ' . $e->getMessage()], 500);
        }
    }
    
    
}
