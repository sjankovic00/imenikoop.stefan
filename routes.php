<?php
use Core\Router;
use Controllers\Auth;
use Controllers\Page;


$router = new Router();
$auth = new Auth();
$page = new Page();

$router->get('/', [$auth, 'login']);
$router->post('/login', [$auth, 'login']);
$router->get('/index',[$page, 'index']);
$router->get('/member', [$page, 'single']);
$router->get('/logout', [$auth, 'logout']);

return $router;
