<?php
use Illuminate\Http\Request;

Route::redirect('/', '/login');

    Route::get('/service-worker.js', function () {
    return response(file_get_contents(asset('service-worker.js')), 200, [
    'Content-Type' => 'text/javascript',
    'Cache-Control' => 'public, max-age=3600',
    ]);
});

Route::get('/home', function () {

//     $routeName = auth()->user() && (auth()->user()->is_student || auth()->user()->is_teacher) ? 'admin.calendar.index' : 'admin.home';
    if(auth()->user()){
        if(auth()->user()->is_student)
            $routeName = 'admin.calendar.index';
        else if(auth()->user()->is_teacher)
            $routeName = 'admin.home';
        else if(auth()->user()->is_dlpadmin || auth()->user()->is_dlpmonitoring || auth()->user()->is_dlpsupport)
            $routeName = 'admin.dlp.index';
        else
            $routeName = 'admin.home';
    }

    if (session('status')) {
        return redirect()->route($routeName)->with('status', session('status'));
    }

    return redirect()->route($routeName);
});

Auth::routes(['register' => false]);



Route::middleware('auth')->get('/pusher/beams-auth', function (Request $request) {
    $userID = $request->user()->name; // If you use a different auth system, do your checks here

    $beamsClient = new \Pusher\PushNotifications\PushNotifications(
      array(
       'instanceId' => '8aefb6b4-0974-4390-90cd-0adeb1514910',
       'secretKey'  => 'E1581BA1EAEBCED979ACD8902BC98170DE3536E1584360DA0FD883433A254BEF',
       )
  );

    $userIDInQueryParam = $request->input('user_id');

    if ($userID != $userIDInQueryParam) {
        return response('Inconsistent request', 401);
    } else {
        $beamsToken = $beamsClient->generateToken($userID);
        return response()->json($beamsToken);
    }
})->name('pusher.auth');

// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::match(['get','post'],'pickup_report', 'UsersController@pickup_report')->name('users.pickup_report');
    Route::get('studentpromote','UsersController@student_promote')->name('student.promote');
    Route::get('ajax_userlist','UsersController@ajax_userlist')->name('user.ajaxlist');

    // Lessons
    Route::delete('timetable/destroy', 'TimetablesController@massDestroy')->name('timetable.massDestroy');
    Route::resource('timetable', 'TimetablesController');
    Route::match(['get','post'],'timetables/exportpdf', 'TimetablesController@exporttimetable')->name('timetable.exporttimetable');
    Route::post('timetable/updatetimetable/{timetable}', 'TimetablesController@updatetimetable')->name('timetable.updatetimetable');
    Route::post('timetable/removetimetable/{timetable}', 'TimetablesController@removetimetable')->name('timetable.removetimetable');
    Route::resource('timetable/scheduletemplate', 'ScheduleTemplateController');

    
    //schedule templae
    Route::get('scheduletemplate/create', 'ScheduleTemplateController@create')->name('scheduletemplate.create');
    Route::get('scheduletemplate/{scheduletemplate}/edit', 'ScheduleTemplateController@edit')->name('scheduletemplate.edit'); //edit
    Route::match(['PUT','PATCH'],'scheduletemplate/{scheduletemplate}/edit', 'ScheduleTemplateController@update')->name('scheduletemplate.update'); //edit

    Route::get('scheduletemplate/{scheduletemplate}/detail', 'ScheduleTemplateController@templatedetail')->name('scheduletemplate.detail'); 
    Route::post('scheduletemplatedetail/create', 'ScheduleTemplateController@templatedetailcreate')->name('scheduletemplatedetail.create');    
    Route::get('scheduletemplatedetail/edit/{scheduletemplatedetail}', 'ScheduleTemplateController@templatedetailedit')->name('scheduletemplatedetail.edit');
    
    
    Route::get('scheduletemplate','ScheduleTemplateController@index')->name('scheduletemplate.index');
    
    Route::match(['PUT','PATCH'],'scheduletemplatedetail/update/{scheduletemplatedetail}', 'ScheduleTemplateController@templatedetailupdate')->name('scheduletemplatedetail.update');
    Route::delete('scheduletemplatedetail/delete/{scheduletemplatedetail}', 'ScheduleTemplateController@templatedetaildelete')->name('scheduletemplatedetail.delete');
    // School Classes
    Route::delete('school-classes/destroy', 'SchoolClassesController@massDestroy')->name('school-classes.massDestroy');
    Route::resource('school-classes', 'SchoolClassesController');

    Route::get('calendar', 'CalendarController@index')->name('calendar.index');

    Route::match(['post','get'],'dlpreport', 'dlpController@report')->name('dlp.report');
    Route::get('dlp', 'dlpController@index')->name('dlp.index');
    Route::get('dlp/getdlp', 'dlpController@getdlp')->name('dlp.getdlp');

    Route::get('dlp/getclass', 'dlpController@getclass')->name('dlp.getclass');
    Route::post('dlp/addnew', 'dlpController@addnew')->name('dlp.addnew');
    Route::post('dlp/update', 'dlpController@update')->name('dlp.update');

    Route::resource('announcement', 'AnnouncementController');

    Route::match(['post','get'],'attendance/generate', 'AttendanceController@generateattendance')->name('attendance.generate');
    Route::resource('attendance', 'AttendanceController');
    Route::resource('feedback', 'FeedbackController');
    Route::resource('message', 'NotificationController');
    Route::resource('homework', 'HomeworkController');
    Route::get('homeworks/{homework}/view', 'HomeworkController@view')->name('homework.view');
    Route::post('homeworks/{homework}/done', 'HomeworkController@done')->name('homework.done');
    Route::get('homeworks/completed', 'HomeworkController@completed')->name('homework.completed');
    Route::get('homeworks/ajaxhomework', 'HomeworkController@ajaxhomework')->name('homework.ajaxhomework');
    Route::post('homeworks/ajaxupload', 'HomeworkController@ajaxupload')->name('homework.ajaxupload');
    Route::get('homeworks/ajaxhomeworkdetail', 'HomeworkController@homeworkDetail')->name('homework.homeworkdetail');
    Route::match(['PUT','PATCH'],'homeworks/{homework}/savescore', 'HomeworkController@savescore')->name('homework.savescore');
    Route::post('homeworks/updateimgae','HomeworkController@updateimgae')->name('homework.updateimgae');
    
    Route::delete('course/destroy', 'CourseController@massDestroy')->name('course.massDestroy');
    Route::resource('course', 'CourseController');
    Route::post('course/ajax/getlist', 'CourseController@getList')->name('course.getlist');

    Route::resource('examschedule', 'ExamscheduleController')->except(['create','show']);
    Route::match(['post','get'],'createexamschedule','ExamscheduleController@create')->name('examschedule.create');

    Route::resource('elearning', 'ElearningController')->except(['create','show']);
    Route::put('elearning/changestatus/{elearning}', 'ElearningController@changestatus')->name('elearning.changestatus');
    Route::match(['post','get'],'elearning/create','ElearningController@create')->name('elearning.create');

    Route::get('teachers/{campus}','SchoolClassesController@getteacher')->name('getteacher');

    //Route::post('announcement/create', 'AnnouncementController@create')->name('announcement.create');

//     Route::get('pusher', 'HomeController@sendNotification');

    Route::get('calling_dashboard/{campus}/{category}', 'CallingController@dashboard')->name('calling.dashboard');
    Route::get('calling_dashboard/getwaiting', 'CallingController@getwaiting')->name('calling.getwaiting');
    Route::post('calling_dashboard/action_update/{rfid}', 'CallingController@action_update')->name('calling.action_update');
    Route::post('calling_dashboard/action_notification/{rfid}', 'CallingController@action_notification')->name('calling.action_notification');
    Route::get('calling_dashboard/getwaitingvoice', 'CallingController@getwaitingvoice')->name('calling.getwaitingvoice');
    // evenet
    Route::get('events','EventsController@index')->name('events.index'); 
    Route::post('events','EventsController@store')->name('events.store');
    Route::delete('events','EventsController@destroy')->name('events.destroy');
    Route::get('events/create','EventsController@show')->name('events.create');
    Route::get('getEvent','EventsController@getEvent')->name('events.getEvents');
    // events type
    Route::get('events/type','EventTypeController@index')->name('eventsType.index');
    Route::post('events/type','EventTypeController@store')->name('eventsType.store');
    Route::delete('events/type/{id}','EventTypeController@destroy')->name('eventsType.destroy');
    Route::get('events/type/create','EventTypeController@show')->name('eventsType.create');
    Route::get('events/type/{id}/edit','EventTypeController@edit')->name('eventsType.edit');
    Route::post('events/type/{id}/update','EventTypeController@update')->name('eventsType.update');

    // gallary
    Route::post('gallary/destroy','GallaryController@destroy')->name('gallary.destroy');
    Route::get('gallary','GallaryController@index')->name('gallary.index');
    Route::get('gallary/create','GallaryController@create')->name('gallary.create');
    Route::get('gallary/{id}/edit','GallaryController@edit')->name('gallary.edit');
    Route::post('gallary','GallaryController@store')->name('gallary.store');
    Route::post('gallary/{id}/update','GallaryController@update')->name('gallary.update');
    Route::get('gallary/init','GallaryController@initPhoto')->name('gallary.init');
});