<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\studentFlow;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Exports\ReportLogsExport;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login_page');
});

Route::get('/login', function () {
    if (Auth::check()){
        return Redirect::to('/dashboard');
     }
    return view('auth.login');
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('index');

Route::prefix('classroom')->group(function () {
    Route::get('', [ClassroomController::class, 'index']);
    Route::get('create', [ClassroomController::class, 'create']);
    Route::post('store', [ClassroomController::class, 'store']);
    Route::get('edit/{id}', [ClassroomController::class, 'edit']);
    Route::post('update/{id}', [ClassroomController::class, 'update']);
    Route::delete('delete/{id}', [ClassroomController::class, 'destroy']);
    Route::get('report', [ClassroomController::class, 'reportListing']);
    Route::get('/report/export', function () {
        $search = request()->query('search');
        return Excel::download(new ReportLogsExport($search), 'report_logs.xlsx');
    })->name('report.export');
});
Route::prefix('teacher')->group(function () {
    Route::get('', [TeacherController::class, 'index']);
    Route::get('create', [TeacherController::class, 'create']);
    // Route::post('store', [TeacherController::class, 'store']);
    //new route for teacher data
    
    Route::match(['get','post'],'manage_student', [TeacherController::class, 'manage_student']);
    Route::match(['get','post'],'student_create', [TeacherController::class, 'student_create']);


    Route::match(['get','post'],'manage_game', [TeacherController::class, 'manage_game']);
    Route::match(['get','post'],'delete_game/{id}', [TeacherController::class, 'delete_game']);
    Route::match(['get','post'],'edit_game/{id}', [TeacherController::class, 'edit_game']);
    Route::match(['get','post'],'status/{id}', [TeacherController::class, 'status']);


    Route::post('store_data', [TeacherController::class, 'getteacherdata']);
    Route::put('/update/{id}', [TeacherController::class, 'Teacherupdate'])->name('teacher_admin.update');
    Route::get('edit/{id}', [TeacherController::class, 'edit']);
    Route::post('update/{id}', [TeacherController::class, 'update']);
    Route::delete('delete/{id}', [TeacherController::class, 'destroy']);
    // this route for teacher dashboard
    Route::get('teacher_dashboard',[TeacherController::class, 'getTeacherDashboard'])->name('teacher_dashboard');
    //route for teacher subject data 
     Route::get('/subject', [TeacherController::class, 'teacher_subject']);
    // route for teacher courses
     Route::get('/courses', [TeacherController::class, 'totalcourses']); 
     // this route for teacher frame
     Route::get('/frame', [TeacherController::class, 'teacherframe']); 

     // route for add new requested courses
     Route::get('/request_course', [TeacherController::class, 'addnew_requested_course']);
     Route::get('/get-subjects/{classroomId}/{type?}', [TeacherController::class, 'commonGetSubjects'])->name('get.subjects');
     Route::get('/get-topics/{classroom}/{subject}', [TeacherController::class, 'commongetTopics'])->name('get.topics');
     Route::get('/get-subtopics/{topic}/{subject}', [TeacherController::class, 'commongetSubTopics'])->name('get.subtopics');
     Route::get('/my-content-edit/{id}', [TeacherController::class, 'editmycontent'])->name('mycontent.edit');
     Route::post('/mycontent-update/{id}', [TeacherController::class, 'updatemycontent'])->name('mycontent.update');

     // route for add topic

     Route::get('/add-topic', [TeacherController::class, 'addTopic'])->name('topic.index');
     Route::get('/check-topic', [TeacherController::class, 'checkTopic'])->name('topic.check');
     Route::post('/save-topic', [TeacherController::class, 'saveTopic'])->name('topic.save');
     Route::get('/topic-edit/{id}', [TeacherController::class, 'editTopic'])->name('topic.edit');
     Route::put('/topic/{id}', [TeacherController::class, 'topicUpdate'])->name('topic.update');
     Route::delete('/topic-delete/{id}', [TeacherController::class, 'deleteTopic'])->name('topic.delete');
     Route::get('/manage-topic', [TeacherController::class, 'manageTopic'])->name('manage.topic.index');

     // route for su topic 

     Route::get('/add-sub-topic', [TeacherController::class, 'addSubTopic'])->name('subtopic.create');
     Route::post('/save-subtopic', [TeacherController::class, 'saveSubTopic'])->name('subtopic.save');
     Route::get('/manage-subtopic', [TeacherController::class, 'manageSubTopic'])->name('manage.subtopic.index');
     Route::get('/subtopic-edit/{id}', [TeacherController::class, 'editSubTopic'])->name('subtopic.edit');
     Route::put('/subtopic/{id}', [TeacherController::class, 'subtopicUpdate'])->name('subtopic.update');
     Route::delete('/subtopic-delete/{id}', [TeacherController::class, 'deleteSubTopic'])->name('subtopic.delete');

     // homework route 

     Route::get('/add-homework', [TeacherController::class, 'addHomework'])->name('homework.create');
     Route::post('/save_homework', [TeacherController::class, 'homeworkStore']);
     Route::get('/manage-homework', [TeacherController::class, 'manageHomework'])->name('manage.homework.index');
     Route::get('/edit_homework/{id}', [TeacherController::class, 'editHomework'])->name('homework.edit');
     Route::put('/update_homework/{id}', [TeacherController::class, 'updateHomework'])->name('homework.update');
     Route::delete('/homework-delete/{id}', [TeacherController::class, 'destroyHomework'])->name('homework.delete');

     Route::delete('/my-content-delete/{id}', [TeacherController::class, 'destroyMycontent'])->name('mycontent.delete');

     Route::get('/manage-live-class', [TeacherController::class, 'manageLiveClass'])->name('manage.liveclass.index');
     Route::get('/live_class_edit/{id}', [TeacherController::class, 'editLiveClass'])->name('liveclass.edit');

     Route::post('/share_liveclass/{id}', [TeacherController::class, 'shareLiveClass']);
     Route::post('/share_my_content/{id}', [TeacherController::class, 'shareMyContent']);
     Route::post('/upload_url_shares/{id}', [TeacherController::class, 'uploadUrlShares']);
     Route::post('/educational_games_shares/{id}', [TeacherController::class, 'educationGamesShares']);
     Route::post('/homeworks_shares/{id}', [TeacherController::class, 'homeworksShares']);


     Route::match(['get','post'],'/test/test', [TeacherController::class, 'testapi']);

     
     Route::match(['get','post'],'add_video',[TeacherController::class, 'add_video']);
     Route::match(['get','post'],'add_diksh',[TeacherController::class, 'add_diksh']);
     Route::match(['get','post'],'add_game',[TeacherController::class, 'add_game']);

     Route::match(['get','post'],'add_video_update/{id}',[TeacherController::class, 'add_video_update']);
     Route::match(['get','post'],'video_delete/{id}',[TeacherController::class, 'video_delete']);
     Route::match(['get','post'],'class_link',[TeacherController::class, 'class_link']);

     Route::match(['get','post'],'share/{id}',[TeacherController::class, 'share']);
    Route::post('/teacher-change-password', [TeacherController::class, 'changePassword'])->name('teacher.change.password');

     // route add new requested couse in requests table
     Route::post('/store', [TeacherController::class, 'store_requested_data'])->name('store');
     // route for requested data
    Route::get('/manage', [TeacherController::class, 'show_requeted_list'])->name('mycontent.index'); 

    Route::get('/video', [TeacherController::class, 'video']); 
    Route::post('/store-video-log', [TeacherController::class, 'storeReportContent']);
    // Route for frame  requested course
    Route::get('/view',[TeacherController::class, 'getrequestedcourse_status']);

    

    Route::get('ajax/fetchSubjects/{id}', [TeacherController::class, 'getSubjects']);
});

Route::prefix('student')->group(function () {
    Route::get('manage', [StudentController::class, 'index']);
    Route::get('create', [StudentController::class, 'create']);
    Route::post('store', [StudentController::class, 'store']);
    Route::get('edit/{id}', [StudentController::class, 'edit']);
    // Route::post('update/{id}', [StudentController::class, 'update']);
    Route::put('student-update/{id}', [StudentController::class, 'Studentupdate'])->name('students.update');
    Route::delete('delete/{id}', [StudentController::class, 'destroy']);
    Route::get('add-csv-data',[StudentController::class,'addcsvview']);
    Route::post('/add-excel-data', [StudentController::class, 'uploadExcel'])->name('add-student-Excel');
    Route::post('/download-student-details', [StudentController::class, 'downloadStudentDetails'])->name('students.downloadStudentDetails');
});



Route::prefix('subject')->group(function () {
    Route::get('', [SubjectController::class, 'index']);
    Route::get('create', [SubjectController::class, 'create']);
    Route::post('store', [SubjectController::class, 'store']);
    Route::get('edit/{id}', [SubjectController::class, 'edit']);
    // Route::post('update/{id}', [SubjectController::class, 'update']);
    Route::put('/update/{id}', [SubjectController::class, 'update'])->name('subject.update');
    Route::delete('delete/{id}', [SubjectController::class, 'destroy']);
});
Route::prefix('manager')->group(function () {
    Route::get('', [UserController::class, 'index']);
    Route::get('create', [UserController::class, 'create']);
    Route::post('store', [UserController::class, 'store']);
    // this route for edit 
    Route::get('edit/{id}', [UserController::class, 'edit']);

    Route::post('update/{id}', [UserController::class, 'update']);
    Route::delete('delete/{id}', [UserController::class, 'destroy']);
    //this route for user view 
    Route::get('user',[UserController::class, 'getUser'])->name('manager.user');;
});

// route for course
Route::prefix('courses')->group(function () {
    //route for create courses
    Route::get('create', [CoursesController::class, 'create']);
    //route for store create data
    Route::post('store', [CoursesController::class, 'store'])->name("storecourses");
    //route for manage page
    Route::get('manage', [CoursesController::class, 'managedata']);
    Route::post('share-content/{course_id}', [CoursesController::class,'shareAdminContent']);
    Route::get('path-to-fetch-students', [CoursesController::class, 'getStudentsByClassroomAndQuery']);


    // route for request course frame
    Route::get('course_frame', [CoursesController::class, 'getframe']);
    Route::get('getframe_test', [CoursesController::class, 'getframe_test']);
    Route::get('/liveclass-manager', [CoursesController::class, 'manageLiveclass']);
    

    // Route::match(['get','post'],'status/{id}',[CoursesController::class, 'status']);

    Route::post('/update-status', [CoursesController::class, 'updateStatusContent']);

    
    // route for status updata
    Route::post('status', [CoursesController::class, 'updatestatus']);
    // for taecher requested courses
    Route::get('requested_course', [CoursesController::class, 'getrequestedcourse_courses']);
       // added by Akshay
       Route::get('videomanager', [CoursesController::class, 'videomanager']);

       Route::match(['get','post'],'add_video_update/{id}',[TeacherController::class, 'add_video_update']);
       Route::match(['get','post'],'content_delete/{id}',[TeacherController::class, 'content_delete']);

    Route::get('edit_course/{id}', [CoursesController::class, 'edit']);
    Route::put('/update_courses/{id}', [CoursesController::class, 'updatecourses'])->name('update_courses');


    Route::post('update/{id}', [CoursesController::class, 'update']);
    // route for 
    Route::delete('delete/{id}', [CoursesController::class, 'destroy']);

      
});

Route::prefix('dashboard')->group(function () {
// this route for class subject in dashbord page
 Route::get('class_subject', [DashboardController::class, 'getsubject']);
// this route for accsee courses pdf...
 Route::get('course_data', [DashboardController::class, 'getcourse']);
 // this route of play video frame in dashboard
 Route::get('Video_frame', [DashboardController::class, 'getFrame'])->name('frame');
    
});
// route for admin dashbord class in dashbord page
Route::get('dashboard', [DashboardController::class, 'getdashboardclass']);

Route::prefix('studentFlow')->group(function () {
    Route::middleware('Student_Flow')->group(function(){
    });
        Route::match((['get','post']),'index', [studentFlow::class, 'index']);
        Route::match((['get','post']),'timetable', [studentFlow::class, 'timetable']);
        Route::match((['get','post']),'password', [studentFlow::class, 'password']);
        Route::match((['get','post']),'exam', [studentFlow::class, 'exam']);
        Route::match((['get','post']),'logout', [studentFlow::class, 'logout']);
        Route::match((['get','post']),'video', [studentFlow::class, 'video']);
        Route::match((['get','post']),'diksha', [studentFlow::class, 'diksha']);
        Route::match((['get','post']),'games', [studentFlow::class, 'games']);
        Route::match((['get','post']),'course', [studentFlow::class, 'course']);
        Route::match((['get','post']),'class', [studentFlow::class, 'class']);
        Route::match((['get','post']),'homeworks', [studentFlow::class, 'homeworks']);
        Route::get('/change-password', [studentFlow::class, 'showChangePasswordForm'])->name('student.changePassword');
        Route::post('/change-password', [studentFlow::class, 'changePassword'])->name('student.changePassword.post');
        Route::post('/seen_notification/{id}', [studentFlow::class, 'seenNotification'])->name('student.seen.notification');
        
     
    Route::match((['get','post']),'register', [studentFlow::class, 'register']);
    Route::match((['get','post']),'login', [studentFlow::class, 'login']);
    
                                               });

require __DIR__.'/auth.php';

    Route::match((['get','post']),'student_registration', [StudentController::class, 'Student_registration']);
    Route::match((['get','post']),'student_login', [StudentController::class, 'Student_login']); 
    Route::match((['get','post']),'student_dashboard', [StudentController::class, 'student_dashboard']);

    Route::match((['get','post']),'stu_store', [StudentController::class, 'stu_store']);


    