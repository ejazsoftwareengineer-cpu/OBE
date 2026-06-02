<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    return "Cleared!";
});

Route::get('/migrate', function () {
    Artisan::call('migrate');
    return "Migrate!";
});


Route::get('/mail', function () {
    return view('mail.mail');
});

Route::get('/changesession/{session_id}', ['uses' =>'App\Http\Controllers\HomeController@changesession','as' => 'changesession']);
Route::get('/changerole/{role_id}', ['uses' =>'App\Http\Controllers\HomeController@changerole','as' => 'changerole']);
Route::get('/alter', ['uses' =>'App\Http\Controllers\CommonController@alterTable','as' => 'altertable']);
Route::get('send-mail', ['uses' =>'App\Http\Controllers\HomeController@sendMail','as' => 'sendmail']);
Route::get('/home', ['uses' =>'App\Http\Controllers\HomeController@home','as' => 'home']);
Route::get('/', ['uses' =>'App\Http\Controllers\HomeController@index','as' => 'indexlogin']);
Route::post('/user-login', ['uses' =>'App\Http\Controllers\HomeController@userLogin','as' => 'userlogin']);
Route::get('/logout', ['uses' =>'App\Http\Controllers\HomeController@logoutUser','as' => 'logoutuser']);
Route::get('/auto_login', ['uses' =>'App\Http\Controllers\HomeController@auto_login','as' => 'auto_login']);
Route::post('/change-password', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\HomeController@changePassword','as' => 'changepassword']);
Route::get('/reset-password', ['uses' =>'App\Http\Controllers\HomeController@resetPassword','as' => 'resetpassword']);
Route::post('/forget-password', ['uses' =>'App\Http\Controllers\HomeController@forgetPassword','as' => 'forgetpassword']);

//////////////////////////////////////////// Users /////////////////////////////////////
Route::get('/manage-user', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserController@index','as' => 'manageuser']);
Route::get('/add-user', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserController@create','as' => 'adduser']);
Route::post('/store-user', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserController@store','as' => 'storeuser']);
Route::get('/edit-user/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserController@edit','as' => 'edituser']);
Route::post('/update-user', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserController@update','as' => 'updateuser']);
Route::get('/destroy-user', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserController@destroy','as' => 'destroyuser']);
Route::get('/change-status', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserController@changeStatus','as' => 'changestatus']);

////////////////////////////////////////////  Acedemic Year /////////////////////////////////////
Route::get('/manage-acedemicyear', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AcedemicController@index','as' => 'manageacedemicyear']);
Route::get('/add-acedemicyear', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AcedemicController@create','as' => 'addacedemicyear']);
Route::post('/store-acedemicyear', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AcedemicController@store','as' => 'storeacedemicyear']);
Route::get('/edit-acedemicyear/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AcedemicController@edit','as' => 'editacedemicyear']);
Route::post('/update-acedemicyear', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AcedemicController@update','as' => 'updateacedemicyear']);
Route::get('/destroy-acedemicyear', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AcedemicController@destroy','as' => 'destroyacedemicyear']);
Route::get('/change-status-acedemicyear', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AcedemicController@changeStatus','as' => 'changeacedemicyearstatus']);

////////////////////////////////////////////  Sesssion /////////////////////////////////////
Route::get('/manage-session', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\SesssionController@index','as' => 'managesession']);
Route::get('/add-session', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\SesssionController@create','as' => 'addsession']);
Route::post('/store-session', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\SesssionController@store','as' => 'storesession']);
Route::get('/edit-session/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\SesssionController@edit','as' => 'editsession']);
Route::post('/update-session', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\SesssionController@update','as' => 'updatesession']);
Route::get('/destroy-session', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\SesssionController@destroy','as' => 'destroysession']);
Route::get('/change-status-session', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\SesssionController@changeStatus','as' => 'changesessionstatus']);

////////////////////////////////////////////  Acedemic Year /////////////////////////////////////

Route::get('/manage-assesment', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AssesmentController@index','as' => 'manageassesment']);
Route::get('/add-assesment', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AssesmentController@create','as' => 'addassesment']);
Route::post('/store-assesment', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AssesmentController@store','as' => 'storeassesment']);
Route::get('/edit-assesment/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AssesmentController@edit','as' => 'editassesment']);
Route::post('/update-assesment', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AssesmentController@update','as' => 'updateassesment']);
Route::get('/destroy-assesment', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AssesmentController@destroy','as' => 'destroyassesment']);
Route::get('/change-status-assesment', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AssesmentController@changeStatus','as' => 'changeassesmentstatus']);


// /////////////////// USER PROFILE //////////////////
Route::get('/user-profile', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserController@profile','as' => 'userprofile']);

// /////////////////// USER PROFILE //////////////////
Route::get('/user-changepassword', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserController@changepassword','as' => 'userchangepassword']);
Route::post('/change-password/update', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserController@updatePassword','as' => 'update-password']);

 

//////////////////////////////////////////// Student /////////////////////////////////////
Route::get('/manage-student', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\StudentController@index','as' => 'managestudent']);
Route::get('/add-student', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\StudentController@create','as' => 'addstudent']);
Route::post('/store-student', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\StudentController@store','as' => 'storestudent']);
Route::get('/edit-student/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\StudentController@edit','as' => 'editstudent']);
Route::post('/update-student', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\StudentController@update','as' => 'updatestudent']);
Route::get('/destroy-student', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\StudentController@destroy','as' => 'destroystudent']);
Route::get('/change-student-status', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\StudentController@changeStatus','as' => 'changestudentstatus']);

///////////////////////// COMMON CONTROLLER ///////////////////////
// Route::post('/get-student-by-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getStudentByProgram','as' => 'getcoursebysemester']);

Route::post('/get-state-by-country', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getStateByCountry','as' => 'getstatebycountry']);
Route::post('/get-cities-by-states', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getCitiesByStates','as' => 'getcitiesbystates']);
Route::get('/get-organization-hierarchy', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getOrganizationHierarchy','as' => 'getorganizationhierarchy']);
// 
Route::post('/get-data-by-function', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getDatabyFunction','as' => 'getdatabyfunction']);
Route::post('/get-roles-by-user', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getRolesByUser','as' => 'getrolesbyuser']);
Route::post('/get-campus-by-organization', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getCampusByOrganization','as' => 'getcampusbyorganization']);
Route::post('/get-institute-by-campus', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getInstituteByCampus','as' => 'getinstitutebycampus']);
Route::post('/get-multiple-institute-by-campus', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getMultipleInstituteByCampus','as' => 'getmultipleinstitutebycampus']);

Route::post('/get-courses-by-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getCoursesbyProgram','as' => 'getcoursesbyprogram']);
Route::post('/get-multiple-courses-by-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getMultipleCoursesbyProgram','as' => 'getMultipleCoursesbyProgram']);
Route::post('/get-course-by-corse_id', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getCourseByCourseId','as' => 'getcoursebycourseid']);
// Route::post('/get-faculty-by-campus', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getFacultyByCampus','as' => 'getfacultybycampus']);
// Route::post('/get-faculty-by-department', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getFacultyByDepartment','as' => 'getfacultybydepartment']);
// Route::post('/get-department-by-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getDepartmentByProgram','as' => 'getdepartmentbyprogram']);
Route::post('/get-institute-by-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getInstituteByProgram','as' => 'getinstitutebyprogram']);
Route::post('/get-student-by-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getStudentByProgram','as' => 'getstudentbyprogram']);
Route::post('/get-cirriculum-by-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getCirriculumByProgram','as' => 'getcirriculumbyprogram']);
Route::post('/get-semester-by-cirriculum', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getSemesterByCirriculum','as' => 'getsemesterbycirriculum']);
Route::post('/get-course-by-semester', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getCourseBySemester','as' => 'getcoursebysemester']);
Route::post('/get-peo-by-programbatch', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getPeoByProgrambatch','as' => 'getpeobyprogrambatch']);
Route::post('/get-plo-by-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getPloByProgram','as' => 'getplobyprogram']);
Route::post('/get-plo-by-programbatch', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getPloByProgrambatch','as' => 'getplobyprogrambatch']);

Route::post('/get-program-by-programbatch', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CommonController@getProgramByProgrambatch','as' => 'getprogrambyprogrambatch']);
///////////////////// USER TYPE //////////////////
Route::get('/manage-usertype', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserTypeController@index','as' => 'manageusertype']);
Route::get('/add-usertype', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserTypeController@create','as' => 'addusertype']);
Route::post('/store-usertype', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserTypeController@store','as' => 'storeusertype']);
Route::get('/edit-usertype/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserTypeController@edit','as' => 'editusertype']);
Route::post('/update-usertype', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserTypeController@update','as' => 'updateusertype']);
Route::get('/destroy-usertype', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserTypeController@destroy','as' => 'destroyusertype']);
Route::get('/change-status-usertype', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserTypeController@changeStatus','as' => 'changeusertypestatus']);


//////////////////////////////////////////// ROLES /////////////////////////////////////
Route::get('/manage-role', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RoleController@index','as' => 'managerole']);
Route::get('/add-role', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RoleController@create','as' => 'addrole']);
Route::post('/store-role', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RoleController@store','as' => 'storerole']);
Route::get('/edit-role/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RoleController@edit','as' => 'editrole']);
Route::post('/update-role', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RoleController@update','as' => 'updaterole']);
Route::get('/destroy-role', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RoleController@destroy','as' => 'destroyrole']);
Route::get('/change-role-status', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RoleController@changeStatus','as' => 'changerolestatus']);
Route::post('/add-role-permission', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RoleController@addRolePermission','as' => 'addRolePermission']);
Route::post('/role-has-permission', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RoleController@roleHasPermission','as' => 'rolehaspermission']);

//////////////////////////////////////////// Module /////////////////////////////////////
Route::get('/manage-module', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ModuleController@index','as' => 'managemodule']);
Route::get('/add-module', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ModuleController@create','as' => 'addmodule']);
Route::post('/store-module', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ModuleController@store','as' => 'storemodule']);
Route::get('/edit-module/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ModuleController@edit','as' => 'editmodule']);
Route::post('/update-module', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ModuleController@update','as' => 'updatemodule']);
Route::get('/destroy-module', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ModuleController@destroy','as' => 'destroymodule']);
Route::get('/change-module-status', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ModuleController@changeStatus','as' => 'changemodulestatus']);

//////////////////////////////////////////// Functionality Permission /////////////////////////////////////
Route::get('/manage-functionalitypermission', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FunctionalityPermissionController@index','as' => 'managefunctionalitypermission']);
Route::get('/add-functionalitypermission', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FunctionalityPermissionController@create','as' => 'addfunctionalitypermission']);
Route::post('/store-functionalitypermission', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FunctionalityPermissionController@store','as' => 'storefunctionalitypermission']);
Route::get('/edit-functionalitypermission/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FunctionalityPermissionController@edit','as' => 'editfunctionalitypermission']);
Route::post('/update-functionalitypermission', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FunctionalityPermissionController@update','as' => 'updatefunctionalitypermission']);
Route::get('/destroy-functionalitypermission', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FunctionalityPermissionController@destroy','as' => 'destroyfunctionalitypermission']);
Route::get('/change-functionalitypermission-status', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FunctionalityPermissionController@changeStatus','as' => 'changefunctionalitypermissionstatus']);

//////////////////////////////////////////// PERMISSIONS /////////////////////////////////////
Route::get('/manage-permission', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PermissionController@index','as' => 'managepermission']);
Route::get('/add-permission', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PermissionController@create','as' => 'addpermission']);
Route::post('/store-permission', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PermissionController@store','as' => 'storepermission']);
Route::get('/edit-permission/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PermissionController@edit','as' => 'editpermission']);
Route::post('/update-permission', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PermissionController@update','as' => 'updatepermission']);
Route::get('/destroy-permission', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PermissionController@destroy','as' => 'destroypermission']);
Route::get('/change-permission-status', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PermissionController@changeStatus','as' => 'changepermissionstatus']);

//////////////////////////////////////////// Organization /////////////////////////////////////

Route::get('/manage-organization', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\OrganizationController@index','as' => 'manageorganization']);
Route::get('/add-organization', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\OrganizationController@create','as' => 'addorganization']);
Route::post('/store-organization', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\OrganizationController@store','as' => 'storeorganization']);
Route::get('/edit-organization/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\OrganizationController@edit','as' => 'editorganization']);
Route::post('/update-organization', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\OrganizationController@update','as' => 'updateorganization']);
Route::post('/update-organization', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\OrganizationController@update','as' => 'updateorganization']);
Route::get('/destroy-organization', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\OrganizationController@destroy','as' => 'destroyorganization']);
Route::get('/change-status-organization', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\OrganizationController@changeStatus','as' => 'changeorganizationstatus']);
Route::get('/organization-campus/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\OrganizationController@organizationCampus','as' => 'organizationcampus']);
Route::get('/get-organization-campus/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\OrganizationController@getorganizationCampus','as' => 'getorganizationcampus']);

//////////////////////////////////////////// Campus /////////////////////////////////////

Route::get('/manage-campus', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CampusController@index','as' => 'managecampus']);
Route::get('/add-campus', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CampusController@create','as' => 'addcampus']);
Route::post('/store-campus', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CampusController@store','as' => 'storecampus']);
Route::get('/edit-campus/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CampusController@edit','as' => 'editcampus']);
Route::post('/update-campus', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CampusController@update','as' => 'updatecampus']);
Route::get('/destroy-campus', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CampusController@destroy','as' => 'destroycampus']);
Route::get('/change-status-campus', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CampusController@changeStatus','as' => 'changecampusstatus']);

Route::get('/campus-institute/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\OrganizationController@campusInstitute','as' => 'campusinstitute']);
Route::get('/get-campus-institute/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\OrganizationController@getcampusInstitute','as' => 'getcampusinstitute']);

//////////////////////////////////////////// Institute /////////////////////////////////////
Route::get('/manage-institute', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\InstituteController@index','as' => 'manageinstitute']);
Route::get('/add-institute', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\InstituteController@create','as' => 'addinstitute']);
Route::post('/store-institute', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\InstituteController@store','as' => 'storeinstitute']);
Route::get('/edit-institute/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\InstituteController@edit','as' => 'editinstitute']);
Route::post('/update-institute', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\InstituteController@update','as' => 'updateinstitute']);
Route::get('/destroy-institute', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\InstituteController@destroy','as' => 'destroyinstitute']);
Route::get('/change-status-institute', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\InstituteController@changeStatus','as' => 'changeinstitutestatus']);

// //////////////////////////////////////////// Faculty /////////////////////////////////////
// Route::get('/manage-faculty', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FacultyController@index','as' => 'managefaculty']);
// Route::get('/add-faculty', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FacultyController@create','as' => 'addfaculty']);
// Route::post('/store-faculty', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FacultyController@store','as' => 'storefaculty']);
// Route::get('/edit-faculty/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FacultyController@edit','as' => 'editfaculty']);
// Route::post('/update-faculty', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FacultyController@update','as' => 'updatefaculty']);
// Route::get('/destroy-faculty', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FacultyController@destroy','as' => 'destroyfaculty']);
// Route::get('/change-status-faculty', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FacultyController@changeStatus','as' => 'changefacultystatus']);

//////////////////////////////////////////// Department /////////////////////////////////////
// Route::get('/manage-department', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\DepartmentController@index','as' => 'managedepartment']);
// Route::get('/add-department', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\DepartmentController@create','as' => 'adddepartment']);
// Route::post('/store-department', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\DepartmentController@store','as' => 'storedepartment']);
// Route::get('/edit-department/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\DepartmentController@edit','as' => 'editdepartment']);
// Route::post('/update-department', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\DepartmentController@update','as' => 'updatedepartment']);
// Route::get('/destroy-department', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\DepartmentController@destroy','as' => 'destroydepartment']);
// Route::get('/change-status-department', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\DepartmentController@changeStatus','as' => 'changedepartmentstatus']);

//////////////////////////////////////////// Program /////////////////////////////////////

Route::get('/manage-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramController@index','as' => 'manageprogram']);
Route::get('/add-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramController@create','as' => 'addprogram']);
Route::post('/store-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramController@store','as' => 'storeprogram']);
Route::get('/edit-program/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramController@edit','as' => 'editprogram']);
Route::post('/update-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramController@update','as' => 'updateprogram']);
Route::get('/destroy-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramController@destroy','as' => 'destroyprogram']);
Route::get('/change-status-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramController@changeStatus','as' => 'changeprogramstatus']);

//////////////////////////////////////////// Courses /////////////////////////////////////
Route::get('/manage-course', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseController@index','as' => 'managecourse']);
Route::get('/add-course', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseController@create','as' => 'addcourse']);
Route::post('/store-course', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseController@store','as' => 'storecourse']);
Route::get('/edit-course/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseController@edit','as' => 'editcourse']);
Route::post('/update-course', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseController@update','as' => 'updatecourse']);
Route::get('/destroy-course', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseController@destroy','as' => 'destroycourse']);
Route::get('/change-status-course', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseController@changeStatus','as' => 'changecoursestatus']);
Route::get('/view-course/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseController@show','as' => 'showcourse']);
Route::get('/view-clo/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseController@showClo','as' => 'showclo']);
Route::get('/add-course-clo/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseController@createCourseClo','as' => 'addcourseclo']);
Route::post('/store-course-clo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseController@storeCourseClo','as' => 'storecourseclo']);

////////////////////////////////////////////  Course Section /////////////////////////////////////
// Route::get('/manage-coursesection', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@index','as' => 'managecoursesection']);
// Route::get('/add-coursesection', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@create','as' => 'addcoursesection']);
// Route::post('/store-coursesection', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@store','as' => 'storecoursesection']);
// Route::get('/edit-coursesection/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@edit','as' => 'editcoursesection']);
// Route::post('/update-coursesection', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@update','as' => 'updatecoursesection']);
// Route::get('/destroy-coursesection', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@destroy','as' => 'destroycoursesection']);
// Route::get('/change-status-coursesection', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@changeStatus','as' => 'changecoursesectionstatus']);
// Route::get('/view-coursesection/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@show','as' => 'showcoursesection']);
// Route::get('/view-coursesectionactivities/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@showCourseSectionActivities','as' => 'showcoursesectionactivities']);
// Route::get('/view-coursesection-activity-question/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@showCourseSectionActivitiesQuestion','as' => 'showcoursesectionactivitiesquestion']);
// Route::post('/get-activity-and-questions', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@getActivityAndQuestions','as' => 'getactivityandquestions']);
// Route::get('/view-coursesectionclo/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@showCourseSectionClo','as' => 'showcoursesectionclo']);
// Route::get('/view-coursesectionstudent/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@showCourseSectionStudent','as' => 'showcoursesectionstudent']);
// Route::post('/store-coursesection-activities', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@storeActivities','as' => 'storecoursesectionactivities']);
// Route::post('/store-coursesection-activities-question', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@storeActivitiesQuestion','as' => 'storecoursesectionactivitiesquestion']);
// Route::get('/map-coursesection-plo/{id}/{coursesection}/{course}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@mapCourseSectionPlo','as' => 'mapcoursesectionplo']);
// Route::post('/store-plo-by-clo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@storePloByClo','as' => 'storeplobyclo']);
// Route::post('/store-exiting-student', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@storeExistingStudents','as' => 'addexistingstudent']);

////////////////////////////////////////////  Course Section /////////////////////////////////////
Route::get('/manage-courseoffering', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@index','as' => 'managecourseoffering']);
Route::get('/add-courseoffering', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@create','as' => 'addcourseoffering']);
Route::post('/store-courseoffering', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@store','as' => 'storecourseoffering']);
Route::get('/edit-courseoffering/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@edit','as' => 'editcourseoffering']);
Route::post('/update-courseoffering', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@update','as' => 'updatecourseoffering']);
Route::get('/destroy-courseoffering', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@destroy','as' => 'destroycourseoffering']);
Route::get('/change-status-courseoffering', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@changeStatus','as' => 'changecourseofferingstatus']);
Route::get('/view-courseoffering/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@show','as' => 'showcourseoffering']);
Route::get('/view-courseofferingactivities/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@showCourseOfferingActivities','as' => 'showcourseofferingactivities']);
Route::get('/view-courseoffering-activity-question/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@showCourseOfferingActivitiesQuestion','as' => 'showcourseofferingactivitiesquestion']);
Route::post('/get-activity-and-questions', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@getActivityAndQuestions','as' => 'getactivityandquestions']);
Route::post('/get-edit-activity-view', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@getEditActivityView','as' => 'geteditactivityview']);
Route::post('/get-edit-activity-question-view', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@getEditActivityQuestionView','as' => 'geteditactivityquestionview']);
Route::get('/view-courseofferingclo/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@showCourseOfferingClo','as' => 'showcourseofferingclo']);
Route::get('/view-courseofferingstudent/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@showCourseOfferingStudent','as' => 'showcourseofferingstudent']);
Route::post('/store-courseoffering-activities', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@storeActivities','as' => 'storecourseofferingactivities']);
Route::post('/store-courseoffering-activities-question', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@storeActivitiesQuestion','as' => 'storecourseofferingactivitiesquestion']);
Route::get('/map-courseoffering-plo/{id}/{courseoffering}/{course}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@mapCourseOfferingPlo','as' => 'mapcourseofferingplo']);
Route::post('/store-plo-by-clo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@storePloByClo','as' => 'storeplobyclo']);
Route::post('/store-exiting-student', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@storeExistingStudents','as' => 'addexistingstudent']);
Route::post('/add-exiting-student', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@uploadexistingstudent','as' => 'uploadexistingstudent']);
Route::get('/show-enrolled-student-attendance/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@showEnrolledStudentAttendance','as' => 'showenrolledstudentattendance']);
Route::get('/save-status-attendance', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@storeAttendenceStatus','as' => 'changeattendencestatus']);
Route::get('/show-enrolled-student-assessment/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@showEnrolledStudentAssessment','as' => 'showenrolledstudentassessment']);
Route::post('/get-attendance-by-date', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@getAttendanceByDate','as' => 'getattendancebydate']);
Route::post('/edit-attendance-by-date', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@editAttendanceByDate','as' => 'editattendancebydate']);
Route::post('/view-attendance-by-date', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@viewAttendanceByDate','as' => 'viewattendancebydate']);
Route::post('/get-outcome-view-by-activity', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@getOutcomeViewByActivity','as' => 'getoutcomeviewbyactivity']);
Route::post('/store-outcome', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@storeOutcome','as' => 'storeoutcome']);
Route::post('/calculate-obeweight-against-clo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@calculateObeWeightAgainstClo','as' => 'calculateobeweightagainstclo']);
Route::post('/update-classactivity', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@updateClassActivity','as' => 'updateclassactivity']);
Route::post('/update-classactivity-question', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@updateClassActivityQuestion','as' => 'updateclassactivityquestion']);
Route::get('/destroy-classactivity', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@destroyClassActivity','as' => 'destroyclassactivity']);
Route::get('/destroy-enrolled-student', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@destroyenrolledstudent','as' => 'destroyenrolledstudent']);
Route::get('/destroy-question', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@destroyQuestion','as' => 'destroyquestion']);

Route::post('/update-cloweight', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@updateCloWeight','as' => 'updateCloWeight']);
///////////////////////Mapping OBE////////////////////////////////////////
Route::get('/manage-mapPLO', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\MappingOBEController@mapPlo','as' => 'mapplo']);
Route::post('/get-mapping-view-by-course', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\MappingOBEController@getMappingViewByCourse','as' => 'getmappingviewbycourse']);
Route::post('/get-mapping-view-by-peo-plo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\MappingOBEController@getMappingViewByPeoPlo','as' => 'getmappingviewbypeoplo']);
Route::post('/add-plo-clo-by-course', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\MappingOBEController@addPloCloByCourse','as' => 'addPloCloByCourse']);
Route::post('/add-peo-plo-mapping', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\MappingOBEController@addPeoPloMapping','as' => 'addPeoPloMapping']);
Route::get('/download-excel-templete/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\MappingOBEController@downloadExcelTemplete','as' => 'downloadexceltemplete']);
Route::get('/download-excel-test-template/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\MappingOBEController@downloadExcelTestTemplate','as' => 'downloadexceltesttemplate']);
Route::post('/upload-assessment', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\MappingOBEController@uploadAssessment','as' => 'uploadassessment']);
Route::post('/upload-test-assessment', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\MappingOBEController@uploadTestAssessment','as' => 'uploadtestassessment']);

///////////////////////////////// CQI ////////////////////////////////////////////////
Route::get('/show-cqi/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@showCQI','as' => 'showcqi']);
Route::get('/show-weight/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@showweight','as' => 'showweight']);
Route::post('/store-cqi', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@storeCQI','as' => 'storecqi']);
Route::get('/view-courseoffering-cqiactivity-question/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@showCourseOfferingCqiActivitiesQuestion','as' => 'showcourseofferingcqiactivitiesquestion']);
Route::post('/store-courseoffering-cqiactivities-question', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@storeCqiActivitiesQuestion','as' => 'storecourseofferingcqiactivitiesquestion']);
Route::post('/get-outcome-view-by-cqiactivity', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@getOutcomeViewByCqiActivity','as' => 'getoutcomeviewbycqiactivity']);
Route::post('/store-cqioutcome', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@storeCqiOutcome','as' => 'storecqioutcome']);
Route::post('/store-courseoffering-cqiactivities', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@storeCqiActivities','as' => 'storecourseofferingcqiactivities']);

/////////////////////////// Attainment ////////////////////////////////////////
Route::get('/show-clo-attainment/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AttainmentController@showeCloAttainment','as' => 'showecloattainment']);
Route::get('/show-clo-attainment-new/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AttainmentController@showeCloAttainmentnew','as' => 'showeCloAttainmentnew']);
Route::get('/show-plo-attainment-new/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AttainmentController@showePloAttainmentnew','as' => 'showePloAttainmentnew']);
Route::get('/show-plo-attainment/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AttainmentController@showePloAttainment','as' => 'showeploattainment']);
Route::get('/generate-pdf-for-clo-attainment/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AttainmentController@generatePdfForCloAttainment','as' => 'generatepdfforcloattainment']);
Route::get('/generate-pdf-for-plo-attainment/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AttainmentController@generatePdfForPloAttainment','as' => 'generatepdfforploattainment']);
Route::get('/generate-excel/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AttainmentController@generateExcel','as' => 'generateExcel']);
Route::get('/test-generate-excel/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AttainmentController@testGenerateExcel','as' => 'testGenerateExcel']);
Route::post('/print-clo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AttainmentController@printclo','as' => 'printclo']);
Route::post('/printCloAttainmentPdf', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AttainmentController@printCloAttainmentPdf','as' => 'printCloAttainmentPdf']);
Route::post('/print-plo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AttainmentController@printplo','as' => 'printplo']);
// Route::post('/print-plo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AttainmentController@generatePloPdf','as' => 'printplo']);

//////////////////////////////////////////// PROGRAM BATCH /////////////////////////////////////

Route::get('/manage-programbatch', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramBatchController@index','as' => 'manageprogrambatch']);
Route::get('/add-programbatch', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramBatchController@create','as' => 'addprogrambatch']);
Route::post('/store-programbatch', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramBatchController@store','as' => 'storeprogrambatch']);
Route::get('/edit-programbatch/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramBatchController@edit','as' => 'editprogrambatch']);
Route::post('/update-programbatch', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramBatchController@update','as' => 'updateprogrambatch']);
Route::get('/destroy-programbatch', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramBatchController@destroy','as' => 'destroyprogrambatch']);
Route::get('/change-status-programbatch', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramBatchController@changeStatus','as' => 'changeprogrambatchstatus']);
Route::get('/view-programbatch/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramBatchController@show','as' => 'showprogrambatch']);
Route::get('/view-plo/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramBatchController@showPlo','as' => 'showplo']);
Route::get('/add-plo/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramBatchController@createPlo','as' => 'addplo']);
Route::post('/store-programbatch-plo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramBatchController@storePlo','as' => 'storeplo']);

//////////////////////////////////////////// Category /////////////////////////////////////
Route::get('/manage-category', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CategoryController@index','as' => 'managecategory']);
Route::get('/add-category', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CategoryController@create','as' => 'addcategory']);
Route::post('/store-category', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CategoryController@store','as' => 'storecategory']);
Route::get('/edit-category/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CategoryController@edit','as' => 'editcategory']);
Route::post('/update-category', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CategoryController@update','as' => 'updatecategory']);
Route::get('/destroy-category', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CategoryController@destroy','as' => 'destroycategory']);
Route::get('/change-status-category', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CategoryController@changeStatus','as' => 'changecategorystatus']);

//////////////////////////////////////////// Category /////////////////////////////////////
Route::get('/manage-report', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ReportController@index','as' => 'managereport']);
Route::get('/program-wise-plo-report', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ReportController@programwiseplo','as' => 'programwiseplo']);
Route::post('/print-program-wise-report-pdf', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ReportController@printprogramwisereportpdf','as' => 'printprogramwisereportpdf']);
Route::post('/print-program-wise-report-excel', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ReportController@printprogramwisereportexcel','as' => 'printprogramwisereportexcel']);
Route::post('/view-program-wise-report-excel', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ReportController@programWiseReportView','as' => 'printprogramwisereportview']);

//////////////////////////////////////////// Rubric Score Set /////////////////////////////////////
Route::get('/manage-rubricscoreset', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricScoreSetController@index','as' => 'managerubricscoreset']);
Route::get('/add-rubricscoreset', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricScoreSetController@create','as' => 'addrubricscoreset']);
Route::post('/store-rubricscoreset', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricScoreSetController@store','as' => 'storerubricscoreset']);
Route::get('/edit-rubricscoreset/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricScoreSetController@edit','as' => 'editrubricscoreset']);
Route::post('/update-rubricscoreset', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricScoreSetController@update','as' => 'updaterubricscoreset']);
Route::get('/destroy-rubricscoreset', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricScoreSetController@destroy','as' => 'destroyrubricscoreset']);
Route::get('/change-status-rubricscoreset', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricScoreSetController@changeStatus','as' => 'changerubricscoresetstatus']);

//////////////////////////////////////////// Rubric /////////////////////////////////////
Route::get('/manage-rubric', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricController@index','as' => 'managerubric']);
Route::get('/add-rubric', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricController@create','as' => 'addrubric']);
Route::post('/store-rubric', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricController@store','as' => 'storerubric']);
Route::get('/edit-rubric/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricController@edit','as' => 'editrubric']);
Route::post('/update-rubric', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricController@update','as' => 'updaterubric']);
Route::get('/destroy-rubric', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricController@destroy','as' => 'destroyrubric']);
Route::get('/change-status-rubric', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricController@changeStatus','as' => 'changerubricstatus']);

//////////////////////////////////////////// Cirriculum /////////////////////////////////////
Route::get('/manage-cirriculum', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CirriculumController@index','as' => 'managecirriculum']);
Route::get('/add-cirriculum', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CirriculumController@create','as' => 'addcirriculum']);
Route::post('/store-cirriculum', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CirriculumController@store','as' => 'storecirriculum']);
Route::get('/edit-cirriculum/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CirriculumController@edit','as' => 'editcirriculum']);
Route::post('/update-cirriculum', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CirriculumController@update','as' => 'updatecirriculum']);
Route::get('/destroy-cirriculum', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CirriculumController@destroy','as' => 'destroycirriculum']);
Route::get('/change-status-cirriculum', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CirriculumController@changeStatus','as' => 'changecirriculumstatus']);
Route::get('/course-cirriculum/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CirriculumController@courseCirriculum','as' => 'coursecirriculum']);
Route::get('/view-course-cirriculum/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CirriculumController@viewCourseCirriculum','as' => 'viewcoursecirriculum']);
Route::post('/add-course-cirriculum', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CirriculumController@addCourseCirriculum','as' => 'addcoursecirriculum']);

Route::get('/remove-course-cirriculum', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CirriculumController@removeCourseCirriculum','as' => 'removecoursecirriculum']);

///////////////////////////////////////////// PROGRAM EDUCATION OBJECTIVE ////////////////////////////////
Route::get('/manage-program-education-objective', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PEOController@index','as' => 'manageprogrameducationobjective']);
Route::get('/add-program-education-objective', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PEOController@create','as' => 'addprogrameducationobjective']);
Route::post('/store-program-education-objective', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PEOController@store','as' => 'storeprogrameducationobjective']);
Route::get('/edit-program-education-objective/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PEOController@edit','as' => 'editprogrameducationobjective']);
Route::get('/view-program-education-objective/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PEOController@show','as' => 'showprogrameducationobjective']);
Route::post('/update-program-education-objective', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PEOController@update','as' => 'updateprogrameducationobjective']);
Route::get('/change-status-peo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PEOController@changeStatus','as' => 'changepeostatus']);
Route::get('/change-status-plo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PLOController@changeStatus','as' => 'changeplostatus']);
/////////////////////////// PEO Program ///////////////
Route::post('/add-peo-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PEOController@createPeoProgram','as' => 'addpeoprogram']);
Route::post('/show-peo-programs', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PEOController@showPeoProgrameData','as' => 'showpeoprogramedata']);

/////////////////////////// PEO KPIS ///////////////
Route::post('/add-peo-kpis', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PEOController@createPeoKpis','as' => 'addpeokpis']);
Route::post('/show-peo-kpis', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PEOController@showPeoKpisData','as' => 'showpeokpisdata']);

////////////////////////////// PROGRAM LEARNING OUTCOME ////////////////////////////////
Route::get('/manage-program-learning-outcome', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PLOController@index','as' => 'manageprogramlearningoutcome']);
Route::get('/add-program-learning-outcome', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PLOController@create','as' => 'addprogramlearningoutcome']);
Route::post('/store-program-learning-outcome', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PLOController@store','as' => 'storeprogramlearningoutcome']);
Route::get('/edit-program-learning-outcome/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PLOController@edit','as' => 'editprogramlearningoutcome']);
Route::get('/view-program-learning-outcome/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PLOController@show','as' => 'showprogramlearningoutcome']);
Route::post('/update-program-learning-outcome', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PLOController@update','as' => 'updateprogramlearningoutcome']);

/////////////////////////// PLO PEO ///////////////
Route::post('/add-plo-peo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PLOController@createPloPeo','as' => 'addplopeo']);
Route::post('/show-plo-peo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PLOController@showPloPeoData','as' => 'showplopeodata']);

/////////////////////////// PLO PROGRAM ///////////////
Route::post('/add-plo-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PLOController@createPloProgram','as' => 'addploprogram']);
Route::post('/show-plo-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PLOController@showPloProgramData','as' => 'showploprogramdata']);

/////////////////////////// PLO KPIS ///////////////
Route::post('/add-plo-kpis', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PLOController@createPloKpis','as' => 'addplokpis']);
Route::post('/show-plo-kpis', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PLOController@showPloKpisData','as' => 'showplokpisdata']);

////////////////////////////// COURSE LEARNING OUTCOME ////////////////////////////////

Route::get('/manage-course-learning-outcome', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CLOController@index','as' => 'managecourselearningoutcome']);
Route::get('/add-course-learning-outcome', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CLOController@create','as' => 'addcourselearningoutcome']);
Route::post('/store-course-learning-outcome', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CLOController@store','as' => 'storecourselearningoutcome']);
Route::get('/edit-course-learning-outcome/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CLOController@edit','as' => 'editcourselearningoutcome']);
Route::get('/view-course-learning-outcome/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CLOController@show','as' => 'showcourselearningoutcome']);
Route::post('/update-course-learning-outcome', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CLOController@update','as' => 'updatecourselearningoutcome']);
Route::get('/change-status-clo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CLOController@changeStatus','as' => 'changeclostatus']);
Route::get('/view-plo-of-clo/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CLOController@showPloByClo','as' => 'showplobyclo']);
// Route::get('/view-plo-of-clo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CLOController@mapPloAtClo','as' => 'mapploatclo']);
//////////////////////////////////////////DATATABLE SERVER SIDE ROUTES ////////////////////

Route::get('/module/list', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ModuleController@getModules','as' => 'getmodules']);
Route::get('/get-usertype', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserTypeController@getUserTypes','as' => 'getusertypes']);
Route::get('/get-student', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\StudentController@getStudents','as' => 'getstudents']);
Route::get('/get-user', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\UserController@getUsers','as' => 'getusers']);
Route::get('/get-campus', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CampusController@getCampus','as' => 'getcampus']);
Route::get('/get-assesment', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AssesmentController@getAssesment','as' => 'getassesment']);
Route::get('/get-acedemicyear', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AcedemicController@getAcedemicYear','as' => 'getacedemicyear']);
Route::get('/get-sesssion', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\SesssionController@getSesssions','as' => 'getsesssions']);
Route::get('/get-organization', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\OrganizationController@getOrganizations','as' => 'getorganizations']);
Route::get('/get-program', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramController@getPrograms','as' => 'getprograms']);
Route::get('/get-course', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseController@getCourses','as' => 'getcourses']);
// Route::get('/get-coursesection', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseSectionController@getCourseSections','as' => 'getcoursesections']);
Route::get('/get-courseoffers', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CourseOfferingController@getCourseoffers','as' => 'getcourseoffers']);
Route::get('/get-programbatch', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\ProgramBatchController@getProgramBatchs','as' => 'getprogrambatchs']);
Route::get('/get-category', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CategoryController@getCategorys','as' => 'getcategorys']);
Route::get('/get-cirriculum', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CirriculumController@getCirriculums','as' => 'getcirriculums']);
// Route::get('/get-department', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\DepartmentController@getDepartments','as' => 'getdepartments']);
// Route::get('/get-facultys', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FacultyController@getFacultys','as' => 'getfacultys']);
Route::get('/get-institutes', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\InstituteController@getInstitutes','as' => 'getinstitutes']);
Route::get('/get-functionalitypermission', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\FunctionalityPermissionController@getFunctionalityPermissions','as' => 'getfunctionalitypermission']);
Route::get('/get-peo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PEOController@getPeo','as' => 'getpeo']);
Route::get('/get-plo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\PLOController@getPlo','as' => 'getplo']);
Route::get('/get-clo', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\CLOController@getClo','as' => 'getclo']);

///////////////////////// Rubric /////////////////////
Route::get('/get-rubricscoreset', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricScoreSetController@getRubricScroreSets','as' => 'getrubricscoresets']);
Route::get('/get-rubric', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\RubricController@getRubrics','as' => 'getrubrics']);

//  Integration Controller
Route::get('/obe-data-from-sap', ['uses' =>'App\Http\Controllers\IntegrationController@getUserRecordCurl','as' => 'getoberecordsap']);

Route::get('/calculateAndStoreQuestionAttainment', ['uses' =>'App\Http\Controllers\AttainmentController@calculateAndStoreQuestionAttainment','as' => 'calculateAndStoreQuestionAttainment']);

Route::get('/calculateAndStoreCloAttainment', ['uses' =>'App\Http\Controllers\AttainmentController@calculateAndStoreCloAttainment','as' => 'calculateAndStoreCloAttainment']);

Route::get('/lock-assessment/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AttainmentController@lockAssessment','as' => 'lockassessment']);
Route::get('/lock-assessment-plo/{id}', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\AttainmentController@lockAssessmentPLO','as' => 'lockAssessmentPLO']);
// routes/web.php

Route::get('/download-student-template', ['middleware' => ['auth'],'uses' =>'App\Http\Controllers\StudentController@downloadTemplate','as' => 'downloadstudenttemplate']);


//Status Report 
Route::get('/status-report', [App\Http\Controllers\ReportController::class, 'statusreport'])
    ->middleware(['auth'])
    ->name('status.report');Route::post('/status-report', [App\Http\Controllers\ReportController::class, 'statusreport'])->name('status.report');