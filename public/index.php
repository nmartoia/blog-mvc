<?php

session_start();

require '../src/config/config.php';
require '../vendor/autoload.php';
require SRC . 'helper.php';

$router = new Blog\Router($_SERVER["REQUEST_URI"]);
$router->get('/', "TodoController@index");
$router->get('/login/', "UserController@showLogin");
$router->get('/register/', "UserController@showRegister");
$router->get('/logout/', "UserController@logout");
$router->get('/dashboard/', "TodoController@showAll");
$router->get('/dashboard/nouveau/', "TodoController@create");
$router->get('/dashboard/:todo/', "TodoController@show");
$router->get('/dashboard/:todo/', "TaskController@show");
$router->get('/dashboard/', "TaskController@showAll");
$router->get('/dashboard/:todo/task/:task/check', "TaskController@check");
$router->get('/dashboard/:todo/task/:task/:id/delete', "TaskController@delete");
$router->get('/dashboard/:todo/nouveau/', "TaskController@create");

$router->post('/dashboard/:todo/delete/', "TodoController@delete");
$router->post('/login/', "UserController@login");
$router->post('/register/', "UserController@register");
$router->post('/dashboard/nouveau/', "TodoController@store");
$router->post('/dashboard/task/nouveau', "TaskController@store");
$router->post('/dashboard/:todo/task/:task/delete/', "TaskController@delete");
$router->post('/dashboard/:todo/task/:task', "TaskController@update");
$router->post('/dashboard/:todo/task/:task/check', "TaskController@check");
$router->post('/dashboard/:todo/:desc', "TodoController@update");
$router->post('/dashboard/:todo/nouveau/', "TaskController@create");

$router->run();
