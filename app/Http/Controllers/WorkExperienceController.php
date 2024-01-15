<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkExperienceController extends Controller
{
    //

    public function workexperience_stor(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->string('company')->nullable();
            $table->string('title')->nullable();
    
            $rules = [
                'user_id' => 'required',
                'startdate' => 'required',
                'enddate' => 'required',
                'company' => 'required',
                'title' => 'required',
                
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

}
