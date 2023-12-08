<?php

namespace SophieCalixto\JWTAuthAPI\Controller;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use SophieCalixto\JWTAuthAPI\Database\PDOConnection;
use SophieCalixto\JWTAuthAPI\Model\Task;

class TaskController
{
    public static function index()
    {
        if(!isset($_SERVER['HTTP_AUTHORIZATION']))
        {
            echo json_encode([
                'error' => 'Token nao informado!'
            ]);
            http_response_code(401);
            return;
        }
        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $token = str_replace('Bearer ', '', $token);
        $pdo = PDOConnection::getConnection();
        $query = $pdo->prepare('SELECT * FROM tokens WHERE token = :token');
        $query->execute([
            'token' => $token
        ]);
        $token = $query->fetch(\PDO::FETCH_ASSOC);

        if($token)
        {
            $key = GetJWTSecret::getJWTSecret();
            $decodedToken = JWT::decode($token['token'], new Key($key, 'HS256'));
            $id = $decodedToken->sub;
            $query = $pdo->prepare('SELECT * FROM tasks WHERE user_id = :user_id');
            $query->execute([
                'user_id' => $id
            ]);
            $tasks = array_map(function($task) {
                return new Task($task['id'], $task['title'], $task['description'], $task['user_id'], $task['completed']);
            }, $query->fetchAll(\PDO::FETCH_ASSOC));
            echo json_encode($tasks);
        }
        else
        {
            echo json_encode([
                'error' => 'Token invalido!'
            ]);
            http_response_code(401);
        }
    }

    public static function store()
    {
        echo 'store';
    }

    public static function update(int $id)
    {
        echo 'update' . $id;
    }

    public static function destroy(int $id)
    {
        echo 'destroy' . $id;
    }
}