<?php

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


Route::group(['middleware' => 'web'], function () {
Auth::routes();
Route::group(['middleware' => 'auth'], function () {





    Route::get('/autocomplete', array('as' => 'autocomplete', 'uses'=>'HomeController@autocomplete'));

    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/profile', 'HomeController@index')->name('profil');
    Route::put('profile/edit/{id}',['uses'=>'HomeController@editProfil','as'=>'editMyProfil']);



    Route::get('/calendar', 'HomeController@calendar');
    Route::get('/calendar/events', 'HomeController@getMyCalendar')->name('appointments');
    Route::post('/AddNewAppoint', 'HomeController@storeAppointment')->name('NewAppointment');

    Route::get('/prospects', 'HomeController@prospect');
    Route::group(['prefix'=>'users'],function (){
        Route::post('/newOne',['uses'=>'HomeController@storeUser','as'=>'newUser']);
        Route::get('/list', 'HomeController@users');
        Route::get('/getUsersData',['uses'=>'HomeController@getUsersData','as'=>'UsersData']);
        Route::get('/detail/{id}',['uses'=>'HomeController@viewUserDetails','as'=>'UsersDetails']);
        Route::get('/detail', 'HomeController@usersDetail');
        Route::get('/delete/{id}', 'HomeController@deleteUser')->name('deleteThisUser');
        Route::get('/edit/{id}',['uses'=>'HomeController@editUserDetails','as'=>'UserEdit']);
        Route::put('/edit/{id}',['uses'=>'HomeController@updateUser','as'=>'UserUpdate']);

    });
    Route::group(['prefix'=>'prospects'],function (){
        Route::get('/details', 'HomeController@prospectDetails');
        Route::get('/getProspectsData',['uses'=>'HomeController@getProspectsData','as'=>'ProspectsData']);

        Route::get('/details/{id}',['uses'=>'HomeController@viewProspectDetails','as'=>'ProspectDetails']);
        Route::get('/edit/{id}',['uses'=>'HomeController@editProspectDetails','as'=>'ProspectEdit']);


        Route::post('/AddNewProspect', 'HomeController@saveProspect')->name('checkObjM');
        Route::put('/updateProspect/{id}', 'HomeController@updateProspect')->name('updateProspect');

    });

});
});

