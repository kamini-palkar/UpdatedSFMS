<?php


use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolesAndPermissionController;
use App\Http\Controllers\UsersController;
use App\Models\PermissionModel;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;

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

    Route::get('/create-user', function () {
        return view('admin.User.createUser');
    })->name('create-user')->middleware('can:add-user');

    Route::post('/create-user', [App\Http\Controllers\UsersController::class, 'storeUser'])->name('create-user')->middleware('can:add-user');

    Route::get('/create-user', [App\Http\Controllers\UsersController::class, 'getOrganisationDetails'])->name('create-user');

    Route::get('/get-organisation-code/{id}', [App\Http\Controllers\UsersController::class, 'getOrganisationCode'])->name('get-organisation-code');

    Route::post('/store-organisation-data', [App\Http\Controllers\UsersController::class, 'storeOrganisationData'])->name('store-organisation-data');

    Route::get('/show-user', [App\Http\Controllers\UsersController::class, 'showUser'])->name('show-user')->middleware('can:show-user');

    Route::get('/edit-user/{id}', [App\Http\Controllers\UsersController::class, 'editUser'])->name('edit-user')->middleware('can:edit-user');

    Route::post('/update-user/{id}', [App\Http\Controllers\UsersController::class, 'updateUser'])->middleware('can:edit-user');

    Route::get('/delete-user/{id}', [App\Http\Controllers\UsersController::class, 'destroyUser'])->name('delete-user')->middleware('can:delete-user');

    // organisation module

    Route::get('/show-organisation', function () {
        return view('admin.Organisation.showOrganisation');
    })->middleware('can:show-organisation');

    Route::get('/create-organisation', function () {
        return view('admin.Organisation.createOrganisation');
    })->name('create-organisation')->middleware('can:add-organisation');

    Route::post('/create-organisation', [App\Http\Controllers\OrganisationController::class, 'storeOrganisation'])->name('create-organisation')->middleware('can:add-organisation');
    Route::get('/show-organisation', [App\Http\Controllers\OrganisationController::class, 'showOrganisation'])->name('show-organisation')->middleware('can:show-organisation');

    Route::get('/delete-organisation/{id}', [App\Http\Controllers\OrganisationController::class, 'destroyOrganisation'])->name('delete-organisation')->middleware('can:delete-organisation');

    Route::get('/edit-organisation/{id}', [App\Http\Controllers\OrganisationController::class, 'editOrganisation'])->name('edit-organisation')->middleware('can:edit-organisation');

    Route::post('/update-organisation/{id}', [App\Http\Controllers\OrganisationController::class, 'updateOrganisation'])->name('update-organisation')->middleware('can:edit-organisation');

    // file upload module

    Route::get('/upload-file', function () {
        return view('admin.Files.uploadFile');
    })->name('upload-file')->middleware('can:upload-files');

    Route::post('/upload-file', [App\Http\Controllers\FileUploadController::class, 'storeFiles'])->name('upload-file')->middleware('can:upload-files');

    Route::get('/download/{id}', [App\Http\Controllers\FileUploadController::class, 'downloadFile'])->name('download.file')->middleware('can:download-file');
    Route::get('/view/{id}', [App\Http\Controllers\FileUploadController::class, 'viewFile'])->name('view.file')->middleware('can:download-file');

    Route::get('/show-files', [App\Http\Controllers\FileUploadController::class, 'showFile'])->name('show-files')->middleware('can:show-files');

    Route::get('/delete-file/{id}', [App\Http\Controllers\FileUploadController::class, 'destroyFile'])->name('delete-file')->middleware('can:delete-files');

                  
    // Route::get('/view-receiver/{id}', [App\Http\Controllers\FileUploadController::class, ' viewReceiver'])->name('view-receiver');
    Route::get('/view-receiver/{id}', [App\Http\Controllers\FileUploadController::class, 'viewReceiver'])->name('view-receiver');

// sending email from listing page
    Route::post('/send-email', [App\Http\Controllers\FileUploadController::class, 'sendEmail'])->name('send-email');



// ACL 


// roles module 
Route::get('/addRoles', function () {
    return view('admin.roles.addRoles');
})->name('addRoles')->middleware('can:add-role');

Route::post('/storeRole', [App\Http\Controllers\RolesController::class, 'storeRole'])->name('addRoles')->middleware('can:add-role');

Route::get('showRoles', [App\Http\Controllers\RolesController::class, 'showRole'])->name('show-role')->middleware('can:show-role');

Route::get('/delete-role/{id}', [App\Http\Controllers\RolesController::class, 'destroyRole'])->name('delete-role')->middleware('can:delete-role');

Route::get('/edit-role/{id}', [App\Http\Controllers\RolesController::class, 'editRole'])->name('edit-role')->middleware('can:edit-role');

Route::post('/update-role/{id}', [App\Http\Controllers\RolesController::class, 'updateRole'])->name('update-role')->middleware('can:edit-role');


// permission module 


Route::get('/addPermission', function () {
    return view('admin.permission.addPermission');
})->name('add-permission')->middleware('can:add-permission');


Route::get('/p', function () {
    $permission_data = PermissionModel::all();
    return view('admin.RolesAndPermission.partialFiles.partial', ['permission_data' => $permission_data]);
});


Route::post('/storePermission', [App\Http\Controllers\PermissionController::class, 'storePermission'])->name('add-permission')->middleware('can:add-permission');

Route::get('/showPermission', [App\Http\Controllers\PermissionController::class, 'showPermission'])->name('show-permission')->middleware('can:show-permission');

Route::get('/edit-permission/{id}', [App\Http\Controllers\PermissionController::class, 'editPermission'])->name('edit-permission')->middleware('can:edit-permission');

Route::post('/update-permission/{id}', [App\Http\Controllers\PermissionController::class, 'updatePermission'])->name('update-permission')->middleware('can:edit-permission');

Route::get('/delete-permission/{id}', [App\Http\Controllers\PermissionController::class, 'destroyPermission'])->name('delete-permission')->middleware('can:delete-permission');

// roles and permission 


Route::get('/showroles_and_permission', [RolesAndPermissionController::class, 'showRP'])->name('showroles_and_permission')->middleware('can:role-has-permission');
Route::post('/showroles_and_permission', [RolesAndPermissionController::class, 'storeRolesAndPermission'])->name('showroles_and_permissions');

Route::get('/fetchPermission', [PermissionController::class, 'fetchPermission'])->name('fetchPermission');


Route::post('/check-username', [UsersController::class, 'CheckUsername'])->name('check-username');






});


?>