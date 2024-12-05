<?php

// ========================================
//    This is the Global Functions file
// ========================================
//  You can put Helper Functions here that
//  can be accessed in the whole project

use Core\Response;
use Core\Session;
use Core\ValidationException;

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function abort($code = 404)
{
    http_response_code($code);

    require base_path("views/{$code}.php");

    die();
}

function authorize($condition, $status = Response::FORBIDDEN)
{
    if (!$condition) {
        abort($status);
    }
}

function base_path($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);
    require base_path('views/' . $path);
}

function redirect($path)
{
    header("location: {$path}");
    exit();
}

function old($key, $default = '')
{
    return Core\Session::get('old')[$key] ?? $default;
}

function extractPattern($uri)
{
    $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_-]+)', $uri);
    return $pattern = "#^{$pattern}$#";
}

function get_uid()
{
    return Session::get('user')['user_id'];
}

function formatTimestamp($timestamp, $format = 'M d, Y')
{
    $date = new DateTime($timestamp);
    return $date->format($format);
}

function generateSKU($category, $productName, $fundsName)
{

    $categoryPart = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $category), 0, 6));
    $productPart = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $productName), 0, 4));
    $fundsPart = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $fundsName), 0, 4));

    $sku = $categoryPart . '-' . $productPart . '-' . $fundsPart;

    return $sku;
}

function error_throw($errors = [], $old = [])
{
    ValidationException::throw($errors, $old);
}

function roles_to_int($role)
{
    $roles = [
        'coordinator' => 1,
        'custodian' => 2,
    ];

    $role_string =  trim(strtolower($role));

    return array_key_exists($role_string, $roles) ? $roles[$role_string] : 2;
}

function toast($text = 'Toast!', $background = 'blue', $duration = 3000, $position = 'center')
{
    return Session::flash('notification', [
        'text' => $text,
        'background' => $background,
        'duration' => $duration,
        'position' => $position,
    ]);
}