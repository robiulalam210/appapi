<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\workexperien;



class WorkExperienceController extends Controller
{
    //

    public function workexperience_get(Request $request, $id = null)
    {
        if ($id === null) {
            $work = workexperien::get();
        } else {
            try {
                $work = workexperien::findOrFail($id);
                $work = [$work];
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return response()->json(['error' => 'Work Experience not found '], 404);
            }
        }
        
        $message = "Work Experience Data";
    
        return response()->json(["message" => $message, "data" => $work], 200);
    }
    

    public function workexperience_stor(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
    
            $rules = [
                'user_id' => 'required',
                'startdate' => 'required',
                'enddate' => 'required',
                'company' => 'required',
                'title' => 'required',
                
            ];

            $customMessage = [
                'title.required' => 'title is required',    
            ];
    
            $validator = Validator::make($data, $rules, $customMessage);
    

            try {
                
                $validator->validate();
            
                $user = new workexperien();
               
                $user->user_id = $data['user_id'];
                $user->startdate = $data['startdate'];
                $user->enddate = $data['enddate'];
                $user->company = $data['company'];
                $user->title = $data['title'];
               
            
                $user->save();
    
                $message = "WorkExperience Successfully Added";
                return response()->json(['message' => $message,'users'=>$user], 201);
            } catch (ValidationException $e) {
                // Handle validation errors
                return response()->json($e->errors(), 422);
            }
        }
    }

}
