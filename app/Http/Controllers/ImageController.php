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
    $images = $request->file('images');

    $uploadedImageUrls = [];

    foreach ($images as $image) {
        $filename = $image->getClientOriginalName();
        
        // Use a custom disk if needed, otherwise, omit the third argument
        $image->storeAs('images', $filename, 'my_files');

        // Create image record in the database
        $newImage = Image::create([
            'url' => $filename,
        ]);

        // Store the URL in the response
        $uploadedImageUrls[] = $newImage->url;
    }

    // Return a JSON response with a success message and the URLs of the uploaded images
    return response()->json(['message' => 'Images uploaded successfully', 'image_urls' => $uploadedImageUrls]);
}

    // public function uploadImages(Request $request)
    // {
    //     // Validation rules
    //     $request->validate([
    //         'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for each image
    //     ]);
    
    //     $uploadedImages = [];
    
    //     // Check if images are present in the request
    //     if ($request->hasFile('images')) {
    //         // Iterate through each uploaded image
    //         foreach ($request->file('images') as $image) {
    //             // Log the image details for debugging
    //             \Log::info('Image Details: ' . print_r($image, true));
    
    //             // Store the image in the 'images' directory
    //             $path = $image->store('images');
    
    //             // Log the path for debugging
    //             \Log::info('Image Path: ' . $path);
    
    //             // Store the image path in the response
    //             $uploadedImages[] = $path;
    //         }
    //     }
    
    //     // Return a JSON response with a success message and the paths of the uploaded images
    //     return response()->json(['message' => 'Images uploaded successfully', 'image_paths' => $uploadedImages], 201);
    // }
    



//     public function uploadImages(Request $request)
// {
//     $request->validate([
//         // 'user_id' => 'required|exists:users,id', // Validation for user_id (you can uncomment this if you want to associate images with users)
//         'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation for each image
//     ]);

//     // Find the user by ID (you can uncomment this if you want to associate images with users)
//     // $user = User::find($request->user_id);

//     // Check if the user exists
//     // if (!$user) {
//     //     return response()->json(['error' => 'User not found'], 404);
//     // }

//     $uploadedImages = [];

//     // Check if images are present in the request
//     if ($request->hasFile('images')) {
//         // Iterate through each uploaded image
//         foreach ($request->file('images') as $image) {
//             // Store the image in the 'images' directory
//             $path = $image->store('images');

//             // Create a new image record in the database and associate it with the user (you can modify this if you are associating with users)
//             $uploadedImages[] = $user->images()->create(['file_path' => $path])->id;
//         }
//     }

//     // Return a JSON response with a success message and the IDs of the uploaded images
//     return response()->json(['message' => 'Images uploaded successfully', 'image_ids' => $uploadedImages], 200);
// }


    // public function uploadImages(Request $request)
    // {
    //     $request->validate([
    //         'user_id' => 'required|exists:users,id',
    //         'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         'titles' => 'required|max:255',
    //     ]);
    
    //     $images = $request->file('images');
    //     $titles = $request->input('titles');
    
    //     if (!is_array($images) || !is_array($titles) || count($images) !== count($titles)) {
    //         return response()->json(['error' => 'Invalid images or titles data'], 400);
    //     }
    
    //     try {
    //         $user = User::findOrFail($request->user_id);
    
    //         $uploadedImages = [];
    
    //         DB::beginTransaction();
    
    //         foreach ($images as $key => $image) {
    //             $path = $image->storeAs('images', uniqid().'.'.$image->getClientOriginalExtension());
    //             $title = $titles[$key];
    
    //             $uploadedImages[] = $user->images()->create(['file_path' => $path, 'title' => $title])->id;
    //         }
    
    //         DB::commit();
    
    //         return response()->json(['message' => 'Images uploaded successfully', 'image_ids' => $uploadedImages], 200);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['error' => 'Error uploading images: ' . $e->getMessage()], 500);
    //     }
    // }
    
    
}
