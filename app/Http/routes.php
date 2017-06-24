<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
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