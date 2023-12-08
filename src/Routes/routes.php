<?php

return [
    'POST' => [
        '/login' => 'SophieCalixto\JWTAuthAPI\Controller\LoginController::login',
        '/register' => 'SophieCalixto\JWTAuthAPI\Controller\RegisterController::register',
        '/tasks' => 'SophieCalixto\JWTAuthAPI\Controller\TaskController::store'
    ],
    'GET' => [
        '/tasks' => 'SophieCalixto\JWTAuthAPI\Controller\TaskController::index',
        '/task/{id}' => 'SophieCalixto\JWTAuthAPI\Controller\TaskController::byId'
    ],
    'PUT' => [
        '/task/{id}' => 'SophieCalixto\JWTAuthAPI\Controller\TaskController::update'
    ],
    'DELETE' => [
        '/task/{id}' => 'SophieCalixto\JWTAuthAPI\Controller\TaskController::destroy'
    ]
];