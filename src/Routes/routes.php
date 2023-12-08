<?php

return [
    'POST' => [
        '/login' => 'SophieCalixto\JWTAuthAPI\Controller\LoginController::login',
        '/register' => 'SophieCalixto\JWTAuthAPI\Controller\RegisterController::register',
        '/tasks' => 'SophieCalixto\JWTAuthAPI\Controller\TaskController::store'
    ],
    'GET' => [
        '/tasks' => 'SophieCalixto\JWTAuthAPI\Controller\TaskController::index'
    ],
    'PUT' => [
        '/tasks/{id}' => 'SophieCalixto\JWTAuthAPI\Controller\TaskController::update'
    ],
    'DELETE' => [
        '/tasks/{id}' => 'SophieCalixto\JWTAuthAPI\Controller\TaskController::destroy'
    ]
];