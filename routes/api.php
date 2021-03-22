<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Period;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/students/all', function (Request $request) {
    return Student::all();
});

Route::post('/create-student', function (Request $request) {
    $response = array();
    $checkStudent = Student::where('username', $request->username)->first();
    if($checkStudent){
        $response['error'] = true;
        $response['message'] = 'Student with this username already exists.';
    }else{
        $student = new Student;
        $student->fullname = $request->fullname;
        $student->username = $request->username;
        $student->password = Hash::make($request->password);
        $student->grade = $request->grade;
        $student->save();
        $response['error'] = false;
        $response['message'] = 'Student added successfully.';
        
    }
    echo json_encode($response);
});




Route::get('/teachers/all', function (Request $request) {
    return Teacher::all();
});

Route::post('/create-teacher', function (Request $request) {
    $response = array();
    $checkTeacherUsername = Teacher::where('username', $request->username)->first();
    if($checkTeacherUsername){
        $response['error'] = true;
        $response['message'] = 'Teacher with this username already exists.';
    }else{
        $checkTeacherEmail = Teacher::where('email', $request->email)->first();
        if($checkTeacherEmail){
            $response['error'] = true;
            $response['message'] = 'Teacher with this email already exists.';
        }else{
            $teacher = new Teacher;
            $teacher->fullname = $request->fullname;
            $teacher->username = $request->username;
            $teacher->password = Hash::make($request->password);
            $teacher->email = $request->email;
            $teacher->save();
            $response['error'] = false;
            $response['message'] = 'Teacher added successfully.';
        }
    }
    echo json_encode($response);
});















