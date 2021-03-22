<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use Hash;
use Validator;
use Auth;

class LoginController extends Controller
{
    public function userDashboard()
    {
        $users = User::all();
        $success =  $users;

        return response()->json($success, 200);
    }

    public function adminDashboard()
    {
        $users = Admin::all();
        $success =  $users;

        return response()->json($success, 200);
    }

    public function studentLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if(auth()->guard('student')->attempt(['username' => request('username'), 'password' => request('password')])){
            config(['auth.guards.api.provider' => 'student']);
            $student = Student::select('students.*')->find(auth()->guard('student')->user()->id);
            $success =  $student;
            $success['token'] =  $student->createToken('MyApp',['student'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }

    public function teacherLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => $validator->errors()->all()]);
        }

        if(auth()->guard('teacher')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'teacher']);
            
            $teacher = Teacher::select('teachers.*')->find(auth()->guard('teacher')->user()->id);
            $success =  $teacher;
            $success['token'] =  $teacher->createToken('MyApp',['teacher'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }
}