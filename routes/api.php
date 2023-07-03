<?php
use App\Http\Controllers\Api02\EventsController;
use App\Http\Controllers\Api02\GallaryController;

Route::post('login', 'Api\V1\Admin\UsersApiController@login');

Route::post('register', 'Api\V1\Admin\UsersApiController@register');

Route::post('addattendance', 'Api\V1\Admin\AttendanceApiController@addAttendance');

Route::get('calling-addnew/{rfidcard}', 'Api\V1\Admin\CallingApiController@addnew');

Route::get('getsetting/{setting}', 'Api\V1\Admin\SettingApiController@getSetting');


Route::post('preorder_notify','Api\V1\Admin\CanteenApiController@preorder_notify');
Route::post('topup_notify','Api\V1\Admin\CanteenApiController@topup_notify');
    

Route::get('getannouncementlist','Api\V1\Admin\AnnouncementApiController@getAnnouncementList');
Route::get('getannouncementdetail','Api\V1\Admin\AnnouncementApiController@getAnnouncementDetail');

Route::get('getdatetime','Api\V1\Admin\SettingApiController@getDateTime');
// if (!auth()->guard('api')->check())
//     return ['status'=>false,'message' => 'Unauthorixed'];
// else
//    echo '2';

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('get_abaqrcodelist','Api\V1\Admin\CanteenApiController@get_abaqrcodelist');
    
    Route::get('get_preorderinstruction','Api\V1\Admin\CanteenApiController@get_preorderinstruction');
    Route::get('get_topupinstruction','Api\V1\Admin\CanteenApiController@get_topupinstruction');
    Route::get('get_iwalletinstruction','Api\V1\Admin\CanteenApiController@get_iwalletinstruction');
    Route::get('get-details', 'Api\V1\Admin\UsersApiController@getDetails');
    Route::post('logout', 'Api\V1\Admin\UsersApiController@logout');
    Route::get('collection_card','Api\V1\Admin\UsersApiController@collection_card');

    Route::post('update_cur_ver', 'Api\V1\Admin\UsersApiController@update_cur_usr_ver');
    
    Route::get('getattendance','Api\V1\Admin\AttendanceApiController@getAttendances');
    Route::get('getattendancedetail','Api\V1\Admin\AttendanceApiController@getattandancedetail');
    Route::get('getmonthattendance','Api\V1\Admin\AttendanceApiController@getMonthAttendance');
    Route::get('getnotificationlist','Api\V1\Admin\NotificationApiController@getNotificationList');
    Route::get('getnotificationdetail','Api\V1\Admin\NotificationApiController@getNotificationDetail');
    Route::get('marknotificationread','Api\V1\Admin\NotificationApiController@marktNotificationRead');

    Route::get('markasread','Api\V1\Admin\NotificationApiController@markAsRead');

    Route::post('addfeedback','Api\V1\Admin\FeedbackApiController@addFeedback');
    Route::get('getfeedback','Api\V1\Admin\FeedbackApiController@getFeedbacks');
    Route::get('getfeedbackdetail','Api\V1\Admin\FeedbackApiController@getFeedbacksDetail');
    
    Route::get('getfeedbackcategory','Api\V1\Admin\FeedbackApiController@getFeedbackCategory');

    Route::get('getexamlist','Api\V1\Admin\ExamscheduleApiController@getExamList');
    
    Route::get('getcourselist','Api\V1\Admin\CourseApiController@getCourses');

    Route::get('getelearninglist','Api\V1\Admin\ElearningApiController@getElearning');

    Route::get('gettimetablelist','Api\V1\Admin\TimetableApiController@gettimetable');

    Route::post('change-password', 'Api\V1\Admin\UsersApiController@change_password');

    Route::post('student_add_attachment', 'Api\V1\Admin\HomeworkApiController@student_add_attachment');
    Route::post('student_submit_assignment', 'Api\V1\Admin\HomeworkApiController@student_submit_assignment');
    Route::post('assignment_list', 'Api\V1\Admin\HomeworkApiController@assignment_list');

    Route::post('assignment_detail', 'Api\V1\Admin\HomeworkApiController@assignment_detail');
    Route::post('student_remove_attachment', 'Api\V1\Admin\HomeworkApiController@student_remove_attachment');
    Route::get('logoutotherdevice','Api\V1\Admin\UsersApiController@logoutotherdevice');
    

});

Route::post('send_notification', 'Api\V1\Admin\UsersApiController@send_notification');
Route::get('register_firebasetoken', 'Api\V1\Admin\UsersApiController@register_firebasetoken');
Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {

    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles    
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Lessons
    Route::apiResource('lessons', 'LessonsApiController');

    // School Classes
    Route::apiResource('school-classes', 'SchoolClassesApiController');

    Route::apiResource('school-classes', 'SchoolClassesApiController');

});

Route::get('/events', [EventsController::class, 'getEvent']);
Route::get('/gallary', [GallaryController::class, 'getGallary']);