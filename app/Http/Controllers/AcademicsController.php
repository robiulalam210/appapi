<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Academic;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
class AcademicsController extends Controller
{
    

    public function academics_show(Request $request, $id = null)
{
    if ($id == null) {
        $academic = Academic::get();
    } else {
        $academic = Academic::find($id);
        if (!$academic) {
            return response()->json(["message" => "No Data"], 404);
        }
        $academic = [$academic];
    }

    // Assuming you want to return JSON
    return response()->json($academic, 200);
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

    public function academics_update(Request $request,$id){

        if($request->isMethod('put')){

            $data=$request->all();

           $rules = [
                'degree' => 'required',
                'country' => 'required',
                // 'passingyear' => 'required',
                // 'city' => 'required',
                // 'result' => 'required',
                // 'institution' => 'required',
                // 'user_id' => 'required',
                 // You might want to add more password rules
            ];
    
            $customMessage = [
                'name.required' => 'Name is required',
               
                
            ];
    
            $validator = Validator::make($data, $rules, $customMessage);

            try {
                $validator->validate();
            
                $user =  Academic::find($id);

               
                $user->degree = $data['degree'];
                $user->country = $data['country'];
                // $user->passingyear = $data['passingyear'];
                // $user->city = $data['city'];
                // $user->result = $data['result'];
                // $user->institution = $data['institution'];
                // $user->user_id = $data['user_id'];
            
                $user->save();
    
                $message = "Academics Successfully Update";
                return response()->json(['message' => $message,'users'=>$user], 201);
            } catch (ValidationException $e) {
                // Handle validation errors
                return response()->json($e->errors(), 422);
            }

        }

    }

    public function deleteAcademics(Request $request, $id)
    {
        // Find the user by ID
        $user = Academic::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Perform the soft delete (if soft deletes are enabled)
        $user->delete();

        // Alternatively, for permanent deletion (if soft deletes are not used)
        // $user->forceDelete();

        return response()->json(['message' => 'Academic deleted successfully',"user"=>$user]);
    }


 



}
