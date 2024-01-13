<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Academic;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
class AcademicsController extends Controller
{
    

    public function academics_show(Request $request,$id=null){

        if($id==null){
            $academic=Academic::get();
            return response()->json([$academic],200);
        }

    }
    public function academics_stor(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

    
            $rules = [
                'degree' => 'required',
                'country' => 'required',
                'passingyear' => 'required',
                'city' => 'required',
                'result' => 'required',
                'institution' => 'required',
                'user_id' => 'required',
            ];

            $customMessage = [
                'degree.required' => 'Name is required',    
            ];
    
            $validator = Validator::make($data, $rules, $customMessage);
    

            try {
                $validator->validate();
            
                $user = new Academic();
               
                $user->degree = $data['degree'];
                $user->country = $data['country'];
                $user->passingyear = $data['passingyear'];
                $user->city = $data['city'];
                $user->result = $data['result'];
                $user->institution = $data['institution'];
                $user->user_id = $data['user_id'];
            
                $user->save();
    
                $message = "Academics Successfully Added";
                return response()->json(['message' => $message,'users'=>$user], 201);
            } catch (ValidationException $e) {
                // Handle validation errors
                return response()->json($e->errors(), 422);
            }
        }
    }


    public function uploadImages(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $user = User::find($request->user_id);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $uploadedImages = [];

    foreach ($request->file('images') as $image) {
        $path = $image->store('images');
        $uploadedImages[] = $user->images()->create(['file_path' => $path])->id;
    }

    return response()->json(['message' => 'Images uploaded successfully', 'image_ids' => $uploadedImages], 200);
}


public function uploadImagess(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'titles.*' => 'string|max:255',
    ]);

    $user = User::find($request->user_id);

    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    $uploadedImages = [];

    foreach ($request->file('images') as $key => $image) {
        $path = $image->store('images');
        $title = $request->input('titles.' . $key);

        $uploadedImages[] = $user->images()->create(['file_path' => $path, 'title' => $title])->id;
    }

    return response()->json(['message' => 'Images uploaded successfully', 'image_ids' => $uploadedImages], 200);
}
}
