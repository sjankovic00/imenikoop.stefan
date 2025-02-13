<?php

use Core\Database;
use Core\Router;
use Controllers\Auth;
use Controllers\Page;
use Controllers\AddEdit;


$router = new Router();
$auth = new Auth();
$page = new Page();
$add = new AddEdit();

$router->get('/', [$auth, 'login']);
$router->post('/login', [$auth, 'login']);
$router->get('/index',[$page, 'index']);
$router->get('/member', [$page, 'single']);
$router->get('/logout', [$auth, 'logout']);
$router->get('/add',[$add, 'showAdd']);
$router->post('/add',[$add, 'write']);


return $router;
