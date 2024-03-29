<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// $app->get('/', function () use ($app) {
//     return $app->welcome();
// });

$app->get('/teachers','TeacherController@index');
$app->post('/teachers','TeacherController@store');
$app->get('/teachers/{teachers}','TeacherController@show');
$app->put('/teachers/{teachers}','TeacherController@update');
$app->patch('/teachers/{teachers}','TeacherController@update');
$app->delete('/teachers/{teachers}','TeacherController@destroy');

$app->get('/students','StudentController@index');
$app->post('/students','StudentController@store');
$app->get('/students/{students}','StudentController@show');
$app->put('/students/{students}','StudentController@update');
$app->patch('/students/{students}','StudentController@update');
$app->delete('/students/{students}','StudentController@destroy');


$app->get('/courses','CourseController@index');
$app->get('/courses/{courses}','CourseController@show');

$app->get('/teachers/{teachers}/courses','TeacherCourseController@index');
$app->post('/teachers/{teachers}/courses','TeacherCourseController@store');
$app->put('/teachers/{teachers}/courses/{courses}','TeacherCourseController@update');
$app->patch('/teachers/{teachers}/courses/{courses}','TeacherCourseController@update');
$app->delete('/teachers/{teachers}/courses/{courses}','TeacherCourseController@destroy');

$app->get('/courses/{courses}/students','CourseStudentController@index');
$app->post('/courses/{courses}/students/{students}','CourseStudentController@store');
$app->delete('/courses/{courses}/students/{students}','CourseStudentController@destroy');

$app->post('/oauth/access_token',function() use ($app){
     return response()->json($app->make('oauth2-server.authorizer')->issueAccessToken());
});