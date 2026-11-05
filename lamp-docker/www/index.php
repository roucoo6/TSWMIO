<?php
require_once(__DIR__."/core/I18n.php");
require_once(__DIR__."/core/ViewHelpers.php");
require_once(__DIR__."/core/ViewManager.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');

$controllerName = $_GET["controller"] ?? "events";
$actionName = $_GET["action"] ?? "index";

$controllers = [
    "users" => "UsersController",
    "events" => "EventsController",
    "activities" => "ActivitiesController",
    "language" => "LanguageController"
];

if (!array_key_exists($controllerName, $controllers)) {
    $controllerName = "events";
}

$className = $controllers[$controllerName];
require_once(__DIR__."/controller/".$className.".php");

$controller = new $className();

if (!method_exists($controller, $actionName)) {
    $actionName = "index";
}

$controller->$actionName();