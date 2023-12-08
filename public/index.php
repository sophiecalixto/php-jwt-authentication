<?php

require_once __DIR__ . '/../vendor/autoload.php';

$method = $_SERVER['REQUEST_METHOD'];
$pathInfo = $_SERVER['PATH_INFO'] ?? '/';

if(!$pathInfo || !$method) {
    http_response_code(404);
}

$routes = require __DIR__ . '/../src/Routes/routes.php';

foreach ($routes[$method] as $route => $controllerAction) {
    $pattern = "@^" . preg_replace('/\\\{[a-zA-Z0-9_]+\\\}/', '([a-zA-Z0-9_]+)', preg_quote($route)) . "$@D";
    preg_match($pattern, $pathInfo, $matches);
    array_shift($matches);
    if ($matches) {
        list($controller, $action) = explode('::', $controllerAction);
        call_user_func_array([new $controller, $action], $matches);
        exit();
    }
}

$routes[$method][$pathInfo]();