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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/job-list', 'JobListController@getJobList');
Route::post('/job-list', 'JobListController@addJob');
Route::post('/job-list/reset', 'JobListController@resetJobs');
