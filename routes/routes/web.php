<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolesAndPermissionController;
use App\Models\PermissionModel;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;
use App\Models\User;

Route::get('/', function () {
   
    return view('auth.login');
});
Auth::routes();

Route::get('/run-composer', function () {
    exec('composer:update');
    exec('composer:dump-autoload');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('clear-compiled');

    return "Caches cleared successfully & Composer commands executed successfully.";

});

Route::group(['middleware' => ['auth', 'web']], function () {

    Route::get('/home', function () {
        return view('admin.common.main');
    });

    // user module

    Route::post('/create-user', [App\Http\Controllers\UsersController::class, 'storeUser'])->name('create-user')->middleware('can:add-user');

    Route::get('/create-user', [App\Http\Controllers\UsersController::class, 'getOrganisationDetails'])->name('create-user');

    Route::get('/get-organisation-code/{id}', [App\Http\Controllers\UsersController::class, 'getOrganisationCode'])->name('get-organisation-code');

    Route::post('/store-organisation-data', [App\Http\Controllers\UsersController::class, 'storeOrganisationData'])->name('store-organisation-data');

    Route::get('/show-user', [App\Http\Controllers\UsersController::class, 'showUser'])->name('show-user');
   
    Route::post('/user-datatable', [App\Http\Controllers\UsersController::class, 'showDataTable'])->name('user-datatable')->middleware('can:show-user');
    Route::get('/edit-user/{id}', [App\Http\Controllers\UsersController::class, 'editUser'])->name('edit-user')->middleware('can:edit-user');

    Route::post('/update-user/{id}', [App\Http\Controllers\UsersController::class, 'updateUser']);

    Route::get('/delete-user/{id}', [App\Http\Controllers\UsersController::class, 'destroyUser'])->name('delete-user')->middleware('can:delete-user');

    Route::get('/user-status/{id}', [App\Http\Controllers\UsersController::class, 'updateUserStatus'])->name('user-status');

    // organisation module

    // Route::get('/show-organisation', function () {
    //     return view('admin.Organisation.showOrganisation');
    // })->middleware('can:show-organisation');

    Route::get('/create-organisation', [App\Http\Controllers\OrganisationController::class, 'createOrganisation'])->name('create-organisation')->middleware('can:add-organisation');

    Route::post('/store-organisation', [App\Http\Controllers\OrganisationController::class, 'storeOrganisation'])->name('store-organisation')->middleware('can:add-organisation');
    Route::post('/organisation-datatable', [App\Http\Controllers\OrganisationController::class, 'showDataTable'])->name('organisation-datatable')->middleware('can:show-organisation');
    Route::get('/show-organisation', [App\Http\Controllers\OrganisationController::class, 'showOrganisation'])->name('show-organisation');

    Route::get('/delete-organisation/{id}', [App\Http\Controllers\OrganisationController::class, 'destroyOrganisation'])->name('delete-organisation')->middleware('can:delete-organisation');

    Route::get('/edit-organisation/{id}', [App\Http\Controllers\OrganisationController::class, 'editOrganisation'])->name('edit-organisation')->middleware('can:edit-organisation');

    Route::post('/update-organisation/{id}', [App\Http\Controllers\OrganisationController::class, 'updateOrganisation'])->name('update-organisation')->middleware('can:edit-organisation');

    // file upload module
  
    Route::post('/show-datatable', [App\Http\Controllers\FileUploadController::class, 'showDataTable'])->name('show-datatable');
    Route::get('/create-file', [App\Http\Controllers\FileUploadController::class, 'create'])->name('create-file')->middleware('can:upload-files');
    Route::post('/upload-file', [App\Http\Controllers\FileUploadController::class, 'storeFiles'])->name('upload-file')->middleware('can:upload-files');

    Route::get('/download/{id}', [App\Http\Controllers\FileUploadController::class, 'downloadFile'])->name('download.file')->middleware('can:download-file');

    Route::get('/show-files', [App\Http\Controllers\FileUploadController::class, 'showFile'])->name('show-files')->middleware('can:show-files');

  

    Route::get('/delete-file/{id}', [App\Http\Controllers\FileUploadController::class, 'destroyFile'])->name('delete-file')->middleware('can:delete-files');
    Route::get('/view-receiver/{id}', [App\Http\Controllers\FileUploadController::class, 'viewReceiver'])->name('view-receiver');

    Route::get('/view/{id}', [App\Http\Controllers\FileUploadController::class, 'viewFile'])->name('view.file')->middleware('can:download-file');

    // sending email from listing page
    Route::post('/send-email', [App\Http\Controllers\FileUploadController::class, 'sendEmail'])->name('send-email');

  //Dashbord module
  Route::get('/show-Info', [App\Http\Controllers\InfoController::class, 'viewAllOrgData'])->name('show-Info')->middleware('can:view-all-org-data');

  Route::get('/home', [App\Http\Controllers\InfoController::class, 'viewOwnOrgData'])->name('home');

  //Project Module
  Route::get('/show-project', [App\Http\Controllers\ProjectController::class, 'showProject'])->name('show-project');
  Route::post('/project-datatable', [App\Http\Controllers\ProjectController::class, 'showDataTable'])->name('project-datatable');
  Route::get('/create-project', [App\Http\Controllers\ProjectController::class, 'createProject'])->name('create-project');
  Route::post('/store-project', [App\Http\Controllers\ProjectController::class, 'storeProject'])->name('store-project');
  Route::get('/delete-project/{id}', [App\Http\Controllers\ProjectController::class, 'destroyProject'])->name('delete-project')->middleware('can:delete-files');
  Route::get('/edit-project/{id}', [App\Http\Controllers\ProjectController::class, 'editProject'])->name('edit-project')->middleware('can:edit-organisation');
  Route::post('/update-project/{id}', [App\Http\Controllers\ProjectController::class, 'updateProject'])->name('update-project')->middleware('can:edit-organisation');
  Route::get('/project-status/{id}', [App\Http\Controllers\ProjectController::class, 'updateProjectStatus'])->name('project-status');


 // Menus
 Route::resource('Menus', 'App\Http\Controllers\MenuController');
 Route::get('menu-list/{id}', 'App\Http\Controllers\MenuController@menuData');
 Route::get('menu-index', 'App\Http\Controllers\MenuController@index');
 Route::post('menu-list/upload', 'App\Http\Controllers\MenuController@upload');
 Route::get('menu-order/{id}', 'App\Http\Controllers\MenuController@orderData')->name('menu.orderData');
 Route::post('menu-sortable', 'App\Http\Controllers\MenuController@sortData');

 Route::post('/store-selected-menu-item-id', 'App\Http\Controllers\HomeController@storeSelectedMenuItemId');
 Route::get('/get-permissions', 'App\Http\Controllers\HomeController@getpermissions')->name('get-permissions');;
 
    // ACL 

    // roles module 
    Route::get('/addRoles', [App\Http\Controllers\RolesController::class, 'createRole'])->name('addRoles')->middleware('can:add-role');

    Route::post('/storeRole', [App\Http\Controllers\RolesController::class, 'storeRole'])->name('addRoles')->middleware('can:add-role');

    Route::get('showRoles', [App\Http\Controllers\RolesController::class, 'showRole'])->name('show-role')->middleware('can:show-role');

    Route::get('/delete-role/{id}', [App\Http\Controllers\RolesController::class, 'destroyRole'])->name('delete-role')->middleware('can:delete-role');

    Route::get('/edit-role/{id}', [App\Http\Controllers\RolesController::class, 'editRole'])->name('edit-role')->middleware('can:edit-role');

    Route::post('/update-role/{id}', [App\Http\Controllers\RolesController::class, 'updateRole'])->name('update-role')->middleware('can:edit-role');


    // permission module 


    Route::get('/addPermission', [App\Http\Controllers\PermissionController::class, 'createPermission'])->name('add-permission')->middleware('can:add-permission');


    Route::get('/p', function () {
        $permission_data = PermissionModel::all();
        return view('admin.RolesAndPermission.partialFiles.partial', ['permission_data' => $permission_data]);
    });


    Route::post('/storePermission', [App\Http\Controllers\PermissionController::class, 'storePermission'])->name('add-permission')->middleware('can:add-permission');

    Route::get('/showPermission', [App\Http\Controllers\PermissionController::class, 'showPermission'])->name('show-permission')->middleware('can:show-permission');

    Route::get('/edit-permission/{id}', [App\Http\Controllers\PermissionController::class, 'editPermission'])->name('edit-permission')->middleware('can:edit-permission');

    Route::post('/update-permission/{id}', [App\Http\Controllers\PermissionController::class, 'updatePermission'])->name('update-permission')->middleware('can:edit-permission');

    Route::get('/delete-permission/{id}', [App\Http\Controllers\PermissionController::class, 'destroyPermission'])->name('delete-permission')->middleware('can:delete-permission');
    Route::get('/get-submenus/{menu_id}', 'App\Http\Controllers\PermissionController@getSubmenus')->name('get.submenus');   
    Route::get('/get-child-menus/{submenuId}', 'App\Http\Controllers\PermissionController@getChildMenus')->name('get-child-menus');

    // roles and permission 


    Route::get('/showroles_and_permission', [RolesAndPermissionController::class, 'showRP'])->
    name('showroles_and_permission');
    Route::post('/storeshowroles_and_permission', [RolesAndPermissionController::class, 'storeRolesAndPermission'])->name('storeshowroles_and_permission');

    Route::get('/fetchPermission', [PermissionController::class, 'fetchPermission'])->name('fetchPermission');



});


?>