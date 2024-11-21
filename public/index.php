<?php
require_once "../core/database.php";
require_once "../core/helpers.php";

$controller = 'home';
$action = 'index';

if (isset($_GET['controller'])) {
    $controller = $_GET['controller'];
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

require_once "../app/controllers/{$controller}Controller.php";

$controllerClass = ucfirst($controller) . "Controller";
$controllerInstance = new $controllerClass();
$controllerInstance->$action();
?>