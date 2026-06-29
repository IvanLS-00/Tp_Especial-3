<?php
require_once 'config/config.php';
require_once 'app/controllers/ApiController.php';
require_once 'libs_router/router.php';


$router = new Router();

 $router->addRoute('ropas', 'GET',    'ApiController', 'getAllRopa');
 $router->addRoute('ropas/:ID', 'GET', 'ApiController', 'getRopa');
 $router->addRoute('ropas', 'POST', 'ApiController', 'addRopa');
 $router->addRoute('ropas/:ID', 'PUT', 'ApiController', 'updateRopa');
 





    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
