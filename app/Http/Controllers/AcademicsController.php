<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Academics;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
class AcademicsController extends Controller
{
    //

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
                'degree' => 'required',
                'degree' => 'required',
                 // You might want to add more password rules
            ];

            $customMessage = [
                'name.required' => 'Name is required',    
            ];
    
            $validator = Validator::make($data, $rules, $customMessage);
    

            try {
                $validator->validate();
            
                $user = new Academics();
               
                $user->degree = $data['degree'];
                $user->country = $data['country'];
                $user->passingyear = $data['passingyear'];
                $user->city = $data['city'];
                $user->result = $data['result'];
                $user->institution = $data['institution'];
            
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
