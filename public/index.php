<?php

use Core\Session;
use Core\ValidationException;

session_start();

const BASE_PATH = __DIR__ . "/../";

require BASE_PATH . 'vendor/autoload.php';

require BASE_PATH . 'Core/functions.php';

require base_path('db.php');

dd(BASE_PATH);

$router = new \Core\Router();
$routes = require base_path('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

try {
    $router->route($uri, $method);
} catch (ValidationException $exception) {
    Session::flash('errors', $exception->errors);
    Session::flash('old', $exception->old,
    );

    redirect($router->previousUrl());
} catch (PDOException $exception) {
    Session::flash('errors', $exception->getMessage());
    redirect('/500');
} catch (Exception $exception) {
    Session::flash('errors', $exception->getMessage());
    dd($exception->getMessage());
    redirect('/500');
}

Session::unflash();