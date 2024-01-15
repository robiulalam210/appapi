<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\WorkExperience;


class WorkExperienceController extends Controller
{
    //

    public function workexperience_stor(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

        
    
            $rules = [
                'user_id' => 'required',
                'startdate' => 'required',
                // 'enddate' => 'required',
                'company' => 'required',
                'title' => 'required',
                
            ];

            $customMessage = [
                'degree.required' => 'Name is required',    
            ];
    
            $validator = Validator::make($data, $rules, $customMessage);
    

            try {
                $validator->validate();
            
                $user = new WorkExperience();
               
                $user->user_id = $data['user_id'];
                $user->startdate = $data['startdate'];
               
            
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
