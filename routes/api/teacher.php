<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
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

Route::get('/teachers', function (Request $request) {
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

Route::post('teacher/login',[LoginController::class, 'teacherLogin'])->name('teacherLogin');
Route::group( ['prefix' => 'teacher','middleware' => ['auth:teacher-api','scopes:teacher'] ],function(){
   // authenticated staff routes here 
    //Route::get('dashboard',[LoginController::class, 'adminDashboard']);
    
    Route::get('/periods', function (Request $request) {
        return Teacher::find(Auth::id())->periods;
    });
    
    Route::post('/update', function (Request $request) {
        $response = array();
        $teacherid = Auth::id();
        $checkTeacherUsername = Teacher::where('username', $request->username)->where('id', '!=', $teacherid)->first();
        if($checkTeacherUsername){
            $response['error'] = true;
            $response['message'] = 'Teacher with this username already exists.';
        }else{
            $checkTeacherEmail = Teacher::where('email', $request->email)->where('id', '!=', $teacherid)->first();
            if($checkTeacherEmail){
                $response['error'] = true;
                $response['message'] = 'Teacher with this email already exists.';
            }else{
                $teacher = Teacher::find($teacherid);
                $teacher->fullname = $request->fullname;
                $teacher->username = $request->username;
                $teacher->email = $request->email;
                $teacher->save();
                $response['error'] = false;
                $response['message'] = 'Teacher updated successfully.';
            }
        }
        echo json_encode($response);
    });
    
    Route::post('/period/add', function (Request $request) {
        $period = new Period();
        $period->name = $request->name;
        $period->teacher_id = Auth::id();
        $period->save();
        $response['error'] = false;
        $response['message'] = 'Period added successfully.';
        return json_encode($response);
    });

    Route::post('/period/update', function (Request $request) {
        $period = Period::where('id', $request->period_id)->where('teacher_id', Auth::id())->update(['name' => $request->name]);
        $response['error'] = false;
        $response['message'] = 'Period updated successfully.';
        return json_encode($response);
    });
    
    Route::get('/period/{id}/students', function (Request $request) {
        return Period::with('students')->where('id', $request->id)->where('teacher_id', Auth::id())->get();
    });
    
    Route::get('/periods', function (Request $request) {
        return Teacher::find(Auth::id())->periods;
    });
    
    Route::get('/students', function (Request $request) {
        $periods = Period::where('teacher_id', Auth::id())->get();
        $allstudents = array();
        if($periods){
            foreach($periods as $period){
                $students = Period::with('students')->where('id', $period->id)->get();
                foreach($students as $student){
                    $allstudents[] = $student;
                }
            }
        }
        return $allstudents;
    });
    
    Route::post('/period/add/student', function (Request $request) {
        $period = Period::where('id', $request->period_id)->where('teacher_id', Auth::id())->first();
        if($period){
            $period->students()->attach($request->student_id);
            $response['error'] = false;
            $response['message'] = 'Student added to period.';
            return json_encode($response);
        }
    });

    Route::post('/period/remove/student', function (Request $request) {
        $period = Period::where('id', $request->period_id)->where('teacher_id', Auth::id())->first();
        if($period){
            $period->students()->detach($request->student_id);
            $response['error'] = false;
            $response['message'] = 'Student removed from period.';
            return json_encode($response);
        }
    });
    
    Route::get('/details', function (Request $request) {
         return auth()->user();
    });
    
    
});
