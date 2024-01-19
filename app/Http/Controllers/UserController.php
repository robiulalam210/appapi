<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Academic;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //

    public function getuser(Request $request, $id = null)
{
    if ($id === null) {
        $users = User::with('academics')->get();
    } else {
        $user = User::with('academics')->find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $users = [$user];
    }

    $message="User Data get";

    return response()->json(['message'=>$message,'users' => $users], 200);
}

    public function addUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

    
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email', // Added email validation
                'dob' => 'required', 
                'images' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust mime types and max size as needed

                'blood_group' => 'required', 
                'gender' => 'required', 
                'religion' => 'required', 
                'nid_smart' => 'required', 
                'mobile' => 'required', 
                'password' => 'required|min:8', // You might want to add more password rules
            ];
    
            $customMessage = [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Invalid email format',
                'email.unique' => 'Email is already in use',
                'password.required' => 'Password is required',
                'password.min' => 'Password must be at least 8 characters',
            ];
    
            $validator = Validator::make($data, $rules, $customMessage);
    

            try {
                $validator->validate();
                
                // Hash the password before saving
                $data['password'] = bcrypt($data['password']);
    
                // Create and save the user
                $user = new User();
                
                $user->title = $data['title'];
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->dob = $data['dob'];
                $user->images = $data['images'];
                $user->blood_group = $data['blood_group'];
                $user->gender = $data['gender'];
                $user->religion = $data['religion'];
                $user->nid_smart = $data['nid_smart'];
                $user->mobile = $data['mobile'];
                $user->password = $data['password'];
                if ($request->hasFile('images')) {
                    $path = $request->file('images')->store('images_folder');
                    $user->images = $path;
                    $user->save();
                }
    
                $message = "User Successfully Added";
                return response()->json(['message' => $message,'users'=>$user], 201);
            } catch (ValidationException $e) {
                // Handle validation errors
                return response()->json($e->errors(), 422);
            }
        }
    }


    public function updateuser(Request $request,$id)
    {
        if ($request->isMethod('put')) {
            $data = $request->all();
    
            $rules = [
                'name' => 'required',
                'password' => 'required|min:8', // You might want to add more password rules
            ];
    
            $customMessage = [
                'name.required' => 'Name is required',
               
                'password.required' => 'Password is required',
                'password.min' => 'Password must be at least 8 characters',
            ];
    
            $validator = Validator::make($data, $rules, $customMessage);
    
            try {
                $validator->validate();
                
                // Hash the password before saving
                $data['password'] = bcrypt($data['password']);
    
                // Create and save the user
                $user =  User::find($id);
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = $data['password'];
                $user->dob = $data['dob'];
                
                $user->save();
    
                $message = "User  Successfully Update";
                return response()->json(['message' => $message,"user"=>$user], 202);
            } catch (ValidationException $e) {
                // Handle validation errors
                return response()->json($e->errors(), 422);
            }
        }
    }
    public function updatesingledata(Request $request,$id)
    {
        if ($request->isMethod('patch')) {
            $data = $request->all();
    
            $rules = [
                'name' => 'required',
              
            ];
    
            $customMessage = [
                'name.required' => 'Name is required',
                
            ];
    
            $validator = Validator::make($data, $rules, $customMessage);
    
            try {
                $validator->validate();
                
                
                // Create and save the user
                $user =  User::find($id);
                $user->name = $data['name'];
               
                $user->save();
    
                $message = "Name update  Successfully";
                return response()->json(['message' => $message,'userupdate'=>$user], 202);
            } catch (ValidationException $e) {
                // Handle validation errors
                return response()->json($e->errors(), 422);
            }
        }
    }
    public function deletduser($id=null){
      $daata=  User::findorFail($id)->delete();
        $message="User Succesfully Deleted";

        return response()->json(['message'=>$message,"data"=>$daata],200);
    }


   
}
