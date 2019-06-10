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

Route::get('/', 'Admin\\ResearchController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('admin/research', 'Admin\\ResearchController');
Route::resource('admin/interview', 'Admin\\InterviewController');
Route::resource('admin/accepted', 'Admin\\AcceptedController');
Route::resource('admin/declined', 'Admin\\DeclinedController');
Route::resource('admin/events', 'Admin\\EventController');

Route::patch("/admin/ajax/research/save", "Admin\\ResearchController@ajaxUpdate");
Route::patch("/admin/ajax/interview/save", "Admin\\InterviewController@ajaxUpdate");
Route::patch("/admin/ajax/accepted/save", "Admin\\AcceptedController@ajaxUpdate");
Route::patch("/admin/ajax/declined/save", "Admin\\DeclinedController@ajaxUpdate");
Route::patch("/admin/ajax/events/save", "Admin\\EventController@ajaxUpdate");
