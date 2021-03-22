<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Models\Student;
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



Route::post('/create', function (Request $request) {
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

Route::post('student/login',[LoginController::class, 'studentLogin'])->name('studentLogin');
Route::group( ['prefix' => 'student','middleware' => ['auth:student-api','scopes:student'] ],function(){
   
    Route::post('/update', function (Request $request) {
        $response = array();
        $studentid = Auth::id();
        $checkStudent = Student::where('username', $request->username)->where('id', '!=', $studentid)->first();
        if($checkStudent){
            $response['error'] = true;
            $response['message'] = 'Student with this username already exists.';
        }else{
            $student = Student::find($studentid);
            $student->fullname = $request->fullname;
            $student->username = $request->username;
            $student->grade = $request->grade;
            $student->save();
            $response['error'] = false;
            $response['message'] = 'Student updated successfully.';

        }
        echo json_encode($response);
    });
    
});   