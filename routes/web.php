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

Route::get('/', 'FrontendController@index')->name('index');

Route::get('worklogs/start/{id}/{date}/{timeBegin}/{timeEnd}/{notes}', 'WorklogController@start')->name('worklogs.start');

Route::get('worklogs/finish', 'WorklogController@finish')->name('worklogs.finish');

Route::get('worklogs/export', 'WorklogController@export')->name('worklogs.export');

Route::resource('worklogs', 'WorklogController');

Route::resource('projects', 'ProjectController');

Route::resource('projects.subprojects', 'SubprojectController');

Route::get('jobs/{id}/close', 'JobController@close')->name('jobs.close');

Route::resource('jobs', 'JobController');
