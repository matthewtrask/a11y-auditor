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


Route::get('/', 'Web\DashboardController@index');
Route::get('/labels', 'Web\LabelController@index');
Route::post('/labels/add', 'Web\LabelController@create');
Route::get('/{repository}', 'Web\RepositoryController@index');
Route::get('/{repository}/issues/create', 'Web\RepositoryController@fetch');
Route::get('/{repository}/issues/{id}', 'Web\IssueController@fetch');
Route::post('/{repository}/issues/{id}/close', 'Web\IssueController@close');
Route::post('/{repository}/issues/{issueNumber}/comment', 'Web\CommentController@create');
Route::get('/{repository}/labels', 'Web\LabelController@index');
Route::get('/{repository}/labels/create', 'Web\LabelController@index');
Route::post('/{repository}/issue/create', 'Web\IssueController@create');
Route::get('/{repository}/milestones', 'Web\MilestoneController@fetch');
Route::post('/repository/create', 'Web\RepositoryController@create');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
