<?php

/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
|
| Here is where you can register ADMIN routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "admin" middleware group. Enjoy building your ADMIN!
|
*/

Route::group(['middleware' => function (\Illuminate\Http\Request $request, Closure $next) {
    if ($request->session()->exists(\Config::get('admin.session'))) {
        return redirect('/Admin');
    }
    return $next($request);
}], function () {
    Route::get('/login', function () {
        return view('admin/login');
    });
    Route::post('/post-login', 'AdminController@login');
    Route::get('/forgot-password', 'AdminController@forgotPassword');
    Route::post('/forgot-password', 'AdminController@sendForgotPasswordMail');
    Route::get('/reset-password/{id}', 'AdminController@resetPassword');
    Route::post('/reset-password/{id}', 'AdminController@resetPasswordSave');
    Route::get('/check-password', 'AdminController@checkPassword');
});

Route::group(['middleware' => 'admin'], function () {
    //LRF flow route
    Route::get('/logout', function () {
        Session::forget(\Config::get('admin.session'));
        return redirect('Admin/login');
    });
    Route::get('/', 'AdminController@dashboard');
    Route::get('/cms', 'CmsController@cmsList');
    Route::post('/cms/change-status', 'CmsController@changeStatus');
    Route::get('/cms/{id}', 'CmsController@cmsAdd');
    Route::post('/cms/{id}', 'CmsController@Save');

    Route::get('/range', 'RangeController@rangeList');
    Route::post('/range/change-status', 'RangeController@changeStatus');
    Route::post('/range/add/{id?}', 'RangeController@addOrEdit');
    Route::post('/range/save/{id?}', 'RangeController@save')->name('saveTame');
    Route::get('/range/exportExcelFile', 'RangeController@exportExcelFile');
    Route::post('/range/destroy', 'RangeController@destroy');
    Route::post('/range/destroyAll', 'RangeController@destroyAll');

    Route::get('/team', 'TeamController@teamList');
    Route::post('/team/change-status', 'TeamController@changeStatus');
    Route::post('/team/save/{id?}', 'TeamController@save')->name('saveTame');
    Route::get('/team/exportExcelFile', 'TeamController@exportExcelFile');
    Route::post('/team/delete', 'TeamController@delete');

    Route::get('/rarity', 'RarityController@rarityList');
    Route::post('/rarity/change-status', 'RarityController@changeStatus');
    Route::post('/rarity/save/{id?}', 'RarityController@save');
    Route::get('/rarity/exportExcelFile', 'RarityController@exportExcelFile');
    Route::post('/rarity/delete', 'RarityController@delete');

    Route::get('/series', 'SeriesController@seriesList');
    Route::post('/series/change-status', 'SeriesController@changeStatus');
    Route::post('/series/add/{id?}', 'SeriesController@addOrEdit');
    Route::post('/series/save/{id?}', 'SeriesController@save');
    Route::post('/series/destroy', 'SeriesController@destroy');
    Route::post('/series/destroyAll', 'SeriesController@destroyAll');
    Route::get('/series/exportExcelFile', 'SeriesController@exportExcelFile');

    Route::get('/character', 'CharacterController@characterList');
    Route::post('/character/change-status', 'CharacterController@changeStatus');
    Route::get('/character/add/{id?}', 'CharacterController@addOrEdit');
    Route::any('/character/save/{id?}', 'CharacterController@save');
    Route::post('/character/destroy', 'CharacterController@destroy');
    Route::post('/character/destroyAll', 'CharacterController@destroyAll');
    Route::get('/character/find', 'CharacterController@find');
    Route::get('/character/exportExcelFile', 'CharacterController@exportExcelFile');

    Route::get('/users', 'UserController@usersList');
    Route::get('/users/search', 'UserController@searchUser');
    Route::post('/users/change-status', 'UserController@changeStatus');
    Route::get('/users/exportExcelFile', 'UserController@exportExcelFile');

    Route::get('/change-password','AdminController@getChangePassword');
    Route::post('/change-password/save', 'AdminController@changePassword');

});

