<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// session router
Route::post('api/session', 'SessionController@create');
Route::post('api/register', 'UserController@regist');

Route::group([ 'middleware' => 'can' ], function ()
{
    Route::resource('api/project', 'ProjectController');
    Route::resource('api/user', 'UserController');
    // create or update colletion indexes
    // Route::post('sysindexes', 'SysIndexController');
    // user logout
    Route::delete('api/session', 'SessionController@destroy');
});

// project config
Route::group([ 'prefix' => 'api/project/{project_key}', 'middleware' => [ 'can', 'privilege:project:admin_project' ] ], function ()
{
    // project type config
    Route::resource('type', 'TypeController');
    Route::post('type/batch', 'TypeController@handle');
    // project field config
    Route::resource('field', 'FieldController');
    // project screen config
    Route::resource('screen', 'ScreenController');
    // project workflow config
    Route::resource('workflow', 'WorkflowController');
    // project role config
    Route::resource('role', 'RoleController');
    // project priority config
    Route::resource('priority', 'PriorityController');
    Route::post('priority/batch', 'PriorityController@handle');
    // project state config
    Route::resource('state', 'StateController');
    // project resolution config
    Route::resource('resolution', 'ResolutionController');
    Route::post('resolution/batch', 'ResolutionController@handle');
    // project module config
    Route::resource('module', 'ModuleController');
});

Route::group([ 'prefix' => 'api/project/{project_key}', 'middleware' => [ 'can' ] ], function ()
{
    Route::resource('issue', 'IssueController');
    //Route::resource('issue/{issue_id}/comments', 'CommentsController');
});
