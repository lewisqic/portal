<?php

/**
 * Public site routes
 */
Route::group(['namespace' => 'Index'], function () {
    Route::get('/', function() { return redirect('auth/login'); });
});


/**
 * Auth route group
 */
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    // GET
    Route::get('/', function() { return redirect('auth/login'); });
    Route::get('login', ['uses' => 'AuthIndexController@showLogin', 'middleware' => 'guest']);
    Route::get('logout', ['uses' => 'AuthIndexController@handleLogout']);
    Route::get('forgot', ['uses' => 'AuthIndexController@showForgot']);
    Route::get('reset/{code}', ['uses' => 'AuthIndexController@showReset']);
    // POST
    Route::post('login', ['uses' => 'AuthIndexController@handleLogin', 'middleware' => 'guest']);
    Route::post('forgot', ['uses' => 'AuthIndexController@handleForgot']);
    Route::post('reset', ['uses' => 'AuthIndexController@handleReset']);
});


/**
 * Admin route group
 */
Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'checkPermissions:admin'], 'namespace' => 'Admin'], function() {

    // GET
    Route::get('/', ['uses' => 'AdminIndexController@showDashboard']);
    Route::post('remark-setting', ['uses' => 'AdminIndexController@saveRemarkSetting']);

    // profile
    Route::get('profile', ['uses' => 'AdminProfileController@index']);
    Route::put('profile', ['uses' => 'AdminProfileController@update']);

    // files
    Route::get('files/download/{id}', ['uses' => 'AdminFileController@downloadFile']);
    Route::get('files/view/{id}', ['uses' => 'AdminFileController@viewFile']);
    Route::get('files/data', ['uses' => 'AdminFileController@dataTables']);
    Route::post('files/upload', ['uses' => 'AdminFileController@uploadFile']);
    Route::patch('files/{id}', ['uses' => 'AdminFileController@restore']);
    Route::resource('files', 'AdminFileController');

    // file categories
    Route::get('file-categories/data', ['uses' => 'AdminFileCategoryController@dataTables']);
    Route::patch('file-categories/{id}', ['uses' => 'AdminFileCategoryController@restore']);
    Route::resource('file-categories', 'AdminFileCategoryController');

    // member roles
    Route::get('members/roles/data', ['uses' => 'AdminMemberRoleController@dataTables']);
    Route::resource('members/roles', 'AdminMemberRoleController');

    // members
    Route::get('members/data', ['uses' => 'AdminMemberController@dataTables']);
    Route::patch('members/{id}', ['uses' => 'AdminMemberController@restore']);
    Route::resource('members', 'AdminMemberController');

    // activity logs
    Route::get('activity-logs/data', ['uses' => 'AdminActivityLogController@dataTables']);
    Route::resource('activity-logs', 'AdminActivityLogController');

    // administrators
    Route::get('administrators/data', ['uses' => 'AdminAdministratorController@dataTables']);
    Route::patch('administrators/{id}', ['uses' => 'AdminAdministratorController@restore']);
    Route::resource('administrators', 'AdminAdministratorController');

    // administrator roles
    Route::get('roles/data', ['uses' => 'AdminRoleController@dataTables']);
    Route::resource('roles', 'AdminRoleController');

    // settings
    Route::get('settings', ['uses' => 'AdminSettingController@index']);
    Route::post('settings', ['uses' => 'AdminSettingController@update']);

});


/**
 * Account route group
 */
Route::group(['prefix' => 'account', 'middleware' => ['auth:account', 'account'], 'namespace' => 'Account'], function() {

    // Dashboard
    Route::get('/', ['uses' => 'AccountIndexController@showDashboard']);
    Route::get('download-file/{id}', ['uses' => 'AccountIndexController@handleDownloadFile']);
    Route::get('view-file/{id}', ['uses' => 'AccountIndexController@handleViewFile']);
    Route::post('remark-setting', ['uses' => 'AccountIndexController@saveRemarkSetting']);

    // profile
    Route::get('profile', ['uses' => 'AccountProfileController@index']);
    Route::put('profile', ['uses' => 'AccountProfileController@update']);

    // settings
    Route::get('settings', ['uses' => 'AccountSettingController@index']);
    Route::put('settings', ['uses' => 'AccountSettingController@update']);

    // users
    Route::get('users/data', ['uses' => 'AccountUserController@dataTables']);
    Route::patch('users/{id}', ['uses' => 'AccountUserController@restore']);
    Route::resource('users', 'AccountUserController');

    // user roles
    Route::get('roles/data', ['uses' => 'AccountRoleController@dataTables']);
    Route::resource('roles', 'AccountRoleController');

});


/*Route::get('mail', function() {

    $data = [
        'plan' => 'Standard',
        'amount' => \Format::currency(9.95),
        'installment' => 'month',
        'cancelation_date' => \Carbon::now()->toFormattedDateString(),
        'type' => 'upgrade'
    ];

    return new App\Mail\CancelationConfirmation($data);
});*/