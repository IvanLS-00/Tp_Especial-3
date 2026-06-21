<?php
require_once 'config/config.php';
require_once 'app/controllers/ApiController.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$resource = '';
if (!empty( $_GET['resource'])) {
    $resource = $_GET['resource'];
}

$params = explode('/', $resource);
$mainResource = $params[0];

switch ($mainResource) {
    case 'ropa':
        $controller = new ApiController();
        $controller->handleRopa($params);
        break;

    default:
        require_once 'app/views/ApiView.php';
        $view = new ApiView();
        $view->response("Resource not found", 404);
        break;
}