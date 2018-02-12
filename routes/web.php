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

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/', 'FrontendController@index')->name('index');

Route::get('worklogs/start', 'WorklogController@start')->name('worklogs.start');
Route::get('worklogs/finish', 'WorklogController@finish')->name('worklogs.finish');
Route::get('worklogs/export', 'WorklogController@export')->name('worklogs.export');
Route::get('worklogs/{worklog}/restart', 'WorklogController@restart')->name('worklogs.restart');
Route::resource('worklogs', 'WorklogController');

Route::resource('projects', 'ProjectController');
Route::resource('projects.subprojects', 'SubprojectController');

Route::get('jobs/{id}/close', 'JobController@close')->name('jobs.close');
Route::resource('jobs', 'JobController');

Route::prefix('maintenance')->group(function() {
    Route::get('reportSuspiciousWorklogs', 'MaintenanceController@reportSuspiciousWorklogs')->name('maintenance.reportSuspiciousWorklogs');
    Route::get('reportUnassignedProjects', 'MaintenanceController@reportUnassignedProjects')->name('maintenance.reportUnassignedProjects');
    Route::get('reportUnexportedWorklogs', 'MaintenanceController@reportUnexportedWorklogs')->name('maintenance.reportUnexportedWorklogs');
    Route::get('reportUnfinishedWorklogs', 'MaintenanceController@reportUnfinishedWorklogs')->name('maintenance.reportUnfinishedWorklogs');
});

Route::get('/home', 'HomeController@index')->name('home');
