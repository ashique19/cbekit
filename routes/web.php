
<?php



// F1/FAB
// F2/FMA
// F3/FFA


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/




/**
|
|------------------------------------------------------------------------------------
|   Public routes start here
|------------------------------------------------------------------------------------
|
*/





/**
|
|------------------------------------------------------------------------------------
|   Static general purpose public routes
|------------------------------------------------------------------------------------
|
*/


/**
 * 
 * General purpose public pages
 * 
 */
Route::get('/',                 ['as'=>'home',  'uses'=> 'StaticPageController@home']);
Route::get('about-us',          'StaticPageController@about');
Route::get('contact-us',        'StaticPageController@contact');
Route::post('contact-us',       'StaticPageController@postContact');
Route::get('page/{name}',       'StaticPageController@page');
Route::get('blog/{name}',       'StaticPageController@singleBlog');
Route::post('subscribers/subscribe',    'Subscribers@subscribe');
Route::get('subscribers/unsubscribe',   'Subscribers@unsubscribe');
Route::post('subscribers/unsubscribe',  'Subscribers@unsubscribe');
Route::get('pricing',           'StaticPageController@pricing');


/*
|
|-----------------------------------------------------------------------------------
|User Login, Logout, Forgot Password
|-----------------------------------------------------------------------------------    
|
|   3 sets of Routes:
|           - GET   - login landing page
|           - POST  - login form post route
|           - GET   - logout through get
|
|           - GET   - forgot password landing page
|           - POST  - forgot password form post route
|
|           - GET   - Signup landing page
|           - POST  - Signup form post route
|
*/

Route::get('login',             ['as'=>'login', 'uses'=> 'AccessController@login']);
Route::get('signup',            ['as'=>'signup','uses'=> 'AccessController@signup']);
Route::get('logout',            ['as'=>'logout','uses'=> 'AccessController@logout']);

Route::get('verify-email/{code}', 'AccessController@verifyEmail');
Route::post('resend-verification-email', 'AccessController@resendVerificationEmail');

Route::get('forgot-password',   'AccessController@forgotPassword');
Route::post('forgot-password',  'AccessController@postForgotPassword');
Route::get('social/{name}',     'AccessController@social');
Route::post('login',            'AccessController@postLogin');
Route::post('signup',           'AccessController@postSignup');



/**
|
|------------------------------------------------------------------------------------
|   Admin area
|------------------------------------------------------------------------------------
|
*/



Route::group(['middleware' => ['auth','permission'], 'prefix' => 'admin'], function() use ($router)
{
    
    /*
    |
    |-----------------------------------------------------------------------------------
    |Admin Dashboard
    |-----------------------------------------------------------------------------------    
    |
    |   COMMON DASHBOARD for all types of admin
    |   
    |
    */
    
    Route::get('dashboard', ['as'=>'dashboard','uses'=>'Dashboard@index']);


    
    /*
    |
    |-----------------------------------------------------------------------------------
    |User Roles
    |-----------------------------------------------------------------------------------    |
    |
    |   CRUD is done through resource route
    |
    |   Individual ROLE permission is managed through GET and POST request
    |   
    |
    */
    Route::get('roles/{id}/navs', 'Roles@navs');
    Route::post('roles/navs', 'Roles@postNavs');
    Route::get('roles/{id}/permissions', 'Roles@permissions');
    Route::post('roles/permissions', 'Roles@postPermissions');
    Route::resource('roles', 'Roles');







    /*
    |
    |-----------------------------------------------------------------------------------
    |Application Navs
    |-----------------------------------------------------------------------------------
    |
    |   CRUD is done through resource route
    |   
    |   Create, Read, Update only
    |
    */
    Route::resource('navs','Navs', ['except' => ['show', 'destroy', 'edit'] ] );



    /*
    |
    |-----------------------------------------------------------------------------------
    |Application Permission at each Action
    |-----------------------------------------------------------------------------------
    |
    |   CRUD is done through resource route
    |   
    |   Create, Read, Update only
    |
    */
    Route::post('permissions/search',       'Permissions@searchIndex');
    Route::get('permissions/search',        'Permissions@index' );
    Route::get('permissions/auto-update',   'Permissions@index' );
    Route::post('permissions/auto-update',  'Permissions@autoUpdate');
    Route::resource('permissions', 'Permissions');



    /*
    |
    |-----------------------------------------------------------------------------------
    | File manager
    |-----------------------------------------------------------------------------------
    |
    |   El-Finder File manager + Ace Editor
    |
    */
    Route::get('filemanager',        'FileManager@index' );




    /*
    |
    |-----------------------------------------------------------------------------------
    | Social media >> Default->Internal
    |-----------------------------------------------------------------------------------
    |
    |   CRUD is done through resource route
    |   
    */
    Route::post('socials/search', 'Socials@searchIndex');
    Route::get('socials/search', 'Socials@index' );
    Route::resource('socials', 'Socials');


    /*
    |
    |-----------------------------------------------------------------------------------
    |Application Users
    |-----------------------------------------------------------------------------------
    |
    |   CRUD is done through resource route
    |   
    */
    Route::get('user-search/{param}', 'Users@ajaxSearch');
    Route::get('users/search', 'Users@index' );
    Route::post('users/search', 'Users@postSearch');
    Route::resource('users','Users');
    

    /*
    |
    |-----------------------------------------------------------------------------------
    |Change Password
    |-----------------------------------------------------------------------------------
    |
    |   
    */
    Route::get('change-password', 'AccessController@changePassword');
    Route::post('change-password', 'AccessController@postChangePassword');
    
    
    /*
    |
    |-----------------------------------------------------------------------------------
    | Application settings
    |-----------------------------------------------------------------------------------
    |
    |   
    */
    Route::get('settings', 'Settings@index');
    Route::get('settings/edit', 'Settings@edit');
    Route::patch('settings/update', 'Settings@update');
    
    
    /*
    |
    |-----------------------------------------------------------------------------------
    | Static pages
    |-----------------------------------------------------------------------------------
    |
    |   
    */
    Route::post('pages/search', 'Pages@searchIndex');
    Route::get('pages/search', 'Pages@index' );
    Route::resource('pages', 'Pages');
    
    
    /**
    *-------------------------------------------------------------------------------------------
    *   Application > Currencies
    *-------------------------------------------------------------------------------------------
    */
    Route::post('currencies/search', 'Currencies@searchIndex');
    Route::get('currencies/search', 'Currencies@index' );
    Route::resource('currencies', 'Currencies');
    
    /**
    *-------------------------------------------------------------------------------------------
    *   Application > Gateways
    *-------------------------------------------------------------------------------------------
    */
    Route::post('gateways/search', 'Gateways@searchIndex');
    Route::get('gateways/search', 'Gateways@index' );
    Route::resource('gateways', 'Gateways');
    
    /**
    *-------------------------------------------------------------------------------------------
    *   Application > Shippings
    *-------------------------------------------------------------------------------------------
    */
    Route::post('shippings/search', 'Shippings@searchIndex');
    Route::get('shippings/search', 'Shippings@index' );
    Route::resource('shippings', 'Shippings');
    
    
    /*
    |-----------------------------------------------------------------------------------
    |My Profile
    |-----------------------------------------------------------------------------------
    */
    Route::get('my-profile', 'MyProfile@show');
    Route::post('my-profile', 'MyProfile@update');
    Route::get('my-profile/edit', 'MyProfile@edit');
    

    /*
    |-----------------------------------------------------------------------------------
    |Change password
    |-----------------------------------------------------------------------------------
    */
    Route::get('my-profile/change-password', 'MyProfile@changePassword');
    Route::post('my-profile/change-password', 'MyProfile@updatePassword');
    

    /*
    |-----------------------------------------------------------------------------------
    |My Referrals
    |-----------------------------------------------------------------------------------
    */
    Route::get('my-referrals', 'MyProfile@myReferrals');


});


/**
|
|------------------------------------------------------------------------------------
|   User area
|------------------------------------------------------------------------------------
|
*/



Route::group(['middleware'=>'auth','prefix'=>'user'], function()
{
    
    /*
    |-----------------------------------------------------------------------------------
    |My Profile
    |-----------------------------------------------------------------------------------
    */
    Route::get('my-profile', 'Clients@showProfile');
    Route::post('my-profile', 'Clients@updateProfile');
    Route::get('my-profile/edit', 'Clients@editProfile');
    

    /*
    |-----------------------------------------------------------------------------------
    |Change password
    |-----------------------------------------------------------------------------------
    */
    Route::get('my-profile/change-password', 'Clients@changePassword');
    Route::post('my-profile/change-password', 'Clients@updatePassword');


    Route::get('notifications','Notifications@index');
    
});






/**
|
|------------------------------------------------------------------------------------
|   Student area
|------------------------------------------------------------------------------------
|
*/



Route::group(['middleware'=>'auth','prefix'=>'student'], function()
{
    
    Route::get('dashboard', 'Dashboard@student');
    
    Route::get('course/{name}', 'StudentCourses@index');
    Route::get('course/{id}/enrole-free', 'StudentCourses@enroleFree');
    Route::get('course/{id}/enrole-premium', 'StudentCourses@enrolePremium');
    Route::any('course/{id}/update-to-premium', 'StudentCourses@updateToPremium');
    Route::get('course/{id}/select-exam', 'StudentCourses@selectExam');
    Route::get('course/{id}/attempts', 'StudentCourses@attempts');
    
    Route::get('exam/{course_id}/show-help', 'Exams@showHelp');
    Route::get('exam/{course_id}/start', 'Exams@start');
    
    Route::post('quite-exam/{exam_id}', 'Exams@done');
    Route::get('exam-result/{attempt_id}', 'Exams@result');
    Route::get('attempt/{attempt_id}/question/{question_id}/explanation', 'Questions@explanation');
    
    Route::get('show-instruction-pdf', 'Exams@instruction');

    Route::get('exam/{id}/assets', 'Exams@assets');
    Route::get('exam/{id}/instructions', 'Exams@Instructions');
    Route::get('exam/{id}/questions', 'Exams@Questions');

    Route::post('exam/comment/{answer_id}/{question_id}', 'StudentExams@comment');

    Route::get('my-invitations','Students@myInvitations');
    Route::get('my-invitations/{id}/accept','Students@acceptInvitation');
    Route::get('my-invitations/{id}/delete','Students@deleteInvitation');
    
});



/**
|
|------------------------------------------------------------------------------------
|   Teacher area
|------------------------------------------------------------------------------------
|
*/



Route::group(['middleware'=>'auth','prefix'=>'teacher'], function()
{
    
    Route::get('dashboard', 'Dashboard@teacher');
    
    Route::get('course/{name}', 'TeacherCourses@index');
    Route::get('course/{name}/exams', 'TeacherCourses@exams');
    Route::get('course/{name}/students', 'TeacherCourses@students');

    Route::get('course/{name}/questions', 'TeacherQuestions@index');
    Route::get('course/{name}/questions/{question_id}/show', 'TeacherQuestions@show');
    Route::get('course/{name}/questions/{question_id}/edit', 'TeacherQuestions@edit');
    Route::patch('course/{name}/questions/{question_id}/update', 'TeacherQuestions@update');
    Route::get('course/{name}/questions/create', 'TeacherQuestions@create');
    Route::post('course/{name}/questions/update', 'TeacherQuestions@store');
    Route::get('add-question-to-exam/{question_id}/{exam_id}', 'TeacherQuestions@addToExam');
    Route::get('remove-question-from-exam/{question_id}/{exam_id}', 'TeacherQuestions@removeFromExam');


    Route::get('preview-attempts-by-student/{attempt_id}', 'TeacherExams@studentAttemptDetail');
    Route::get('exam-attempts-by-student/{course_id}/{student_id}', 'TeacherExams@studentAttempts');
    Route::get('exam-detail/{attempt_id}/{question_id}/', 'TeacherExams@explanation');
    Route::post('exam/update-mark/{answer_id}/', 'TeacherExams@updateMark');
    Route::post('exam/comment/{answer_id}/{question_id}', 'TeacherExams@comment');
    
    
    Route::resource('exams', 'Exams');
    Route::resource('questions', 'Questions');
    Route::resource('options', 'Options');

    Route::get('my-students/course/{id}', 'MyStudents@course');
    Route::get('my-students/invite-student/{course_id}', 'MyStudents@inviteStudent');
    Route::post('my-students/invite-student/{course_id}', 'MyStudents@postInviteStudent');
    Route::get('my-students/course/{course_id}/add-student/{student_id}', 'MyStudents@addStudent');
    Route::get('my-students/course/{course_id}/pending-invites/sent', 'MyStudents@pendingInvitesSent');
    Route::get('my-students/course/{course_id}/pending-invites/received', 'MyStudents@pendingInvitesReceived');
    
});



/**
|
|------------------------------------------------------------------------------------
|   Editor area
|------------------------------------------------------------------------------------
|
*/



Route::group(['middleware'=>'auth','prefix'=>'editor'], function()
{
    
    Route::get('dashboard', 'Dashboard@editor');
    
    Route::get('course/{name}', 'TeacherCourses@index');
    Route::get('course/{name}/exams', 'TeacherCourses@exams');
    Route::get('course/{name}/students', 'TeacherCourses@students');

    Route::get('course/{name}/questions', 'TeacherQuestions@index');
    Route::get('course/{name}/questions/{question_id}/show', 'TeacherQuestions@show');
    Route::get('course/{name}/questions/{question_id}/edit', 'TeacherQuestions@edit');
    Route::patch('course/{name}/questions/{question_id}/update', 'TeacherQuestions@update');
    Route::get('course/{name}/questions/create', 'TeacherQuestions@create');
    Route::post('course/{name}/questions/update', 'TeacherQuestions@store');
    Route::get('add-question-to-exam/{question_id}/{exam_id}', 'TeacherQuestions@addToExam');
    Route::get('remove-question-from-exam/{question_id}/{exam_id}', 'TeacherQuestions@removeFromExam');


    Route::get('preview-attempts-by-student/{attempt_id}', 'TeacherExams@studentAttemptDetail');
    Route::get('exam-attempts-by-student/{course_id}/{student_id}', 'TeacherExams@studentAttempts');
    Route::get('exam-detail/{attempt_id}/{question_id}/', 'TeacherExams@explanation');
    Route::post('exam/update-mark/{answer_id}/', 'TeacherExams@updateMark');
    Route::post('exam/comment/{answer_id}/{question_id}', 'TeacherExams@comment');
    
    
    Route::resource('exams', 'Exams');
    Route::resource('questions', 'Questions');
    Route::resource('options', 'Options');

    Route::get('my-students/course/{id}', 'MyStudents@course');
    Route::get('my-students/invite-student/{course_id}', 'MyStudents@inviteStudent');
    Route::post('my-students/invite-student/{course_id}', 'MyStudents@postInviteStudent');
    Route::get('my-students/course/{course_id}/add-student/{student_id}', 'MyStudents@addStudent');
    Route::get('my-students/course/{course_id}/pending-invites/sent', 'MyStudents@pendingInvitesSent');
    Route::get('my-students/course/{course_id}/pending-invites/received', 'MyStudents@pendingInvitesReceived');
    
});



/**
*
* admin routes
* 
*/
Route::group(['middleware'=>['auth','permission'],'prefix'=>'admin'], function()
{
    
    
    /*
    |
    |-----------------------------------------------------------------------------------
    | Admin -> Users
    |-----------------------------------------------------------------------------------
    |
    */
    Route::post('user/user-edit-by-admin/{id}','AdminUsers@updateUserData');
    Route::get('user/user-edit-by-admin/{id}','AdminUsers@getAjaxEditData');
    Route::get('user/activate-user/{code}','AdminUsers@activateUser');
    Route::get('user/re-activate-user/{code}','AdminUsers@reactivateUser');
    Route::get('user/de-activate-user/{code}','AdminUsers@deactivateUser');
    Route::get('user/manual-verification/{code}','AdminUsers@manuallyVerifyUser');
    Route::get('user/email-unverified','AdminUsers@emailUnverified');
    Route::get('user/activation-pending','AdminUsers@activationPending');
    Route::get('user/inactive','AdminUsers@inactive');
    Route::get('user/student','AdminUsers@student');
    Route::get('user/teacher','AdminUsers@teacher');
    Route::get('user/institute','AdminUsers@institute');
    
    

    
    /**
    *-------------------------------------------------------------------------------------------
    *   Application > BLOG (Has Many - Slides, Comments)
    *-------------------------------------------------------------------------------------------
    */
    Route::get('blog-search/{param}', 'Blogs@ajaxSearch');
    Route::post('blogs/search',  'Blogs@searchIndex');
    Route::get('blogs/search', 'Blogs@index');
    Route::get('blogs/{id}/comments-create', 'Blogs@commentsCreate');   
    Route::get('blogs/{id}/comments', 'Blogs@comments');   
    Route::post('blogs/{id}/comment', 'Blogs@commentStore');   
    Route::post('blogs/{id}/comment/{comment}', 'Blogs@commentReplyStore');
    Route::get('blog/{id}/remove-related-blog/{related}', 'Blogs@removeRelatedBlog');
    Route::resource('blogs', 'Blogs');
    
    /**
    *-------------------------------------------------------------------------------------------
    *   Application > BLOG > Slides
    *-------------------------------------------------------------------------------------------
    */
    Route::post('blogslides/search', 'Blogslides@searchIndex');
    Route::get('blogslides/search', 'Blogslides@index');
    Route::resource('blogslides', 'Blogslides');
    
    
    /**
    *-------------------------------------------------------------------------------------------
    *   Application > BLOG > Comments
    *-------------------------------------------------------------------------------------------
    */
    Route::post('comments/search', 'Comments@searchIndex');
    Route::get('comments/search', 'Comments@index');
    Route::get('comments/{id}/publish', 'Comments@publish');
    Route::get('comments/{id}/unpublish', 'Comments@unpublish');
    Route::resource('comments', 'Comments');
    
    
    /**
    *-------------------------------------------------------------------------------------------
    *   Application > BLOG CATEGORIES
    *-------------------------------------------------------------------------------------------
    */
    Route::get('blogcategories/{id}/blogs', 'Blogcategories@blogs');
    Route::post('blogcategories/search', 'Blogcategories@searchIndex');
    Route::get('blogcategories/search', 'Blogcategories@index' );
    Route::resource('blogcategories', 'Blogcategories');
    
    
    /**
    *-------------------------------------------------------------------------------------------
    *   Application > BLOG Tags
    *-------------------------------------------------------------------------------------------
    */
    Route::get('blogtags/{id}/blogs', 'Blogtags@blogs');
    Route::post('blogtags/search', 'Blogtags@searchIndex');
    Route::get('blogtags/search', 'Blogtags@index');
    Route::resource('blogtags', 'Blogtags');


});



