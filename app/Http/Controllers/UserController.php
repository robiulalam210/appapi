<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    //

    public function getuser(){

        $users=User::get();
        return response()->json(['users'=>$users],200);

    }
    public function addUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

    
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email', // Added email validation
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
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = $data['password'];
                $user->save();
    
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
                // $user->email = $data['email'];
                $user->password = $data['password'];
                $user->save();
    
                $message = "User  Successfully Update";
                return response()->json(['message' => $message], 202);
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
                // 'email' => 'required|email|unique:users,email', // Added email validation
                // 'password' => 'required|min:8', // You might want to add more password rules
            ];
    
            $customMessage = [
                'name.required' => 'Name is required',
                // 'email.required' => 'Email is required',
                // 'email.email' => 'Invalid email format',
                // 'email.unique' => 'Email is already in use',
                // 'password.required' => 'Password is required',
                // 'password.min' => 'Password must be at least 8 characters',
            ];
    
            $validator = Validator::make($data, $rules, $customMessage);
    
            try {
                $validator->validate();
                
                // Hash the password before saving
                // $data['password'] = bcrypt($data['password']);
    
                // Create and save the user
                $user =  User::find($id);
                $user->name = $data['name'];
                // $user->email = $data['email'];
                // $user->password = $data['password'];
                $user->save();
    
                $message = "User  Successfully Update";
                return response()->json(['message' => $message], 202);
            } catch (ValidationException $e) {
                // Handle validation errors
                return response()->json($e->errors(), 422);
            }
        }
    }
    public function deletduser($id=null){
        User::findorFail($id)->delete();
        $message="User Succesfully Deleted";

        return response()->json(['message'=>$message],200);
    }
}
