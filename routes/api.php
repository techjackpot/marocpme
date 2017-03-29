<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->post('login', 'App\Http\Controllers\api\AuthApiMpmeController@authenticate');
    $api->post('password/email', 'App\Http\Controllers\api\AuthApiMpmeController@sendResetLinkEmail');
//    $api->get('password/reset/{token}', 'App\Http\Controllers\Auth\mpmeApiController@showResetForm');

    $api->post('password/reset', 'App\Http\Controllers\api\AuthApiMpmeController@reset');
});

$api->version('v1', ['middleware' => 'api.auth'], function ($api)  {
    $api->version('v1', ['prefix' => 'users'], function ($api)  {

        $api->get('/',['as'=>'usersE','uses'=>'App\Http\Controllers\api\mpmeApiController@AllUsers']);
        $api->get('/{id}',['uses'=>'App\Http\Controllers\api\mpmeApiController@getOneUser','as'=>'getOneUser']);
        $api->put('/update/{id}',['as'=>'userUpdate','uses'=>'App\Http\Controllers\api\mpmeApiController@updateUser']);
        $api->post('/store',['as'=>'usersStore','uses'=>'App\Http\Controllers\api\mpmeApiController@storeUser']);
        $api->delete('/destroy/{id}',['as'=>'userDestroy','uses'=>'App\Http\Controllers\api\mpmeApiController@destroyUser']);

    });

    $api->version('v1', ['prefix' => 'calendars'], function ($api) {
        $api->get('/', ['as' => 'calendars', 'uses' => 'App\Http\Controllers\api\mpmeApiController@AllCalendars']);

    });


    $api->version('v1', ['prefix' => 'prospects'], function ($api) {
    $api->get('/', 'App\Http\Controllers\api\mpmeApiController@getProspects');
    $api->get('/{id}','App\Http\Controllers\api\mpmeApiController@getProspect');
    $api->put('/edit/{id}',['uses'=>'App\Http\Controllers\HomeController@editProspectDetails','as'=>'ProspectEdit']);
    $api->delete('/destroy/{id}',['uses'=>'App\Http\Controllers\HomeController@editProspectDetails','as'=>'ProspectEdit']);

    $api->post('/AddNewProspect', 'App\Http\Controllers\HomeController@saveProspect')->name('checkObjM');
});


});
