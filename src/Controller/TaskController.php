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
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            echo json_encode([
                'error' => 'Token nao informado!'
            ]);
            http_response_code(401);
            return;
        }
        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $token = str_replace('Bearer ', '', $token);
        $pdo = PDOConnection::getConnection();

        if ($token) {
            $key = GetJWTSecret::getJWTSecret();
            $decodedToken = JWT::decode($token, new Key($key, 'HS256'));
            $id = $decodedToken->sub;
            $query = $pdo->prepare('SELECT * FROM tasks WHERE user_id = :user_id');
            $query->execute([
                'user_id' => $id
            ]);
            echo json_encode(
                array_map(function ($task) {
                    return [
                        "id" => $task['id'],
                        "title" => $task['title'],
                        "description" => $task['description']
                    ];
                }, $query->fetchAll(\PDO::FETCH_ASSOC))
            );
        } else {
            echo json_encode([
                'error' => 'Token invalido!'
            ]);
            http_response_code(401);
        }
    }

    public static function byId(int $id)
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            echo json_encode([
                'error' => 'Token nao informado!'
            ]);
            http_response_code(401);
            return;
        }
        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $token = str_replace('Bearer ', '', $token);
        $pdo = PDOConnection::getConnection();

        if ($token && $id) {
            $key = GetJWTSecret::getJWTSecret();
            $secureKey = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
            if (JWT::decode($token, new Key($key, 'HS256'))) {
                $query = $pdo->prepare('SELECT * FROM tasks WHERE id = :id');
                if ($query->execute([
                    'id' => $secureKey
                ])
                ) {
                    $task = $query->fetch(\PDO::FETCH_ASSOC);
                    echo json_encode(
                        [
                            "id" => $task['id'],
                            "title" => $task['title'],
                            "description" => $task['description']
                        ]
                    );
                } else {
                    echo json_encode([
                        'error' => 'Erro ao procurar por dado no banco de dados!'
                    ]);
                    http_response_code(401);
                }
            } else {
                {
                    echo json_encode([
                        'error' => 'Token invalido!'
                    ]);
                    http_response_code(401);
                }
            }
        }
    }

    public static function store()
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            echo json_encode([
                'error' => 'Token nao informado!'
            ]);
            http_response_code(401);
            return;
        }

        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $token = str_replace('Bearer ', '', $token);
        $pdo = PDOConnection::getConnection();

        if ($token && $_POST['title'] && $_POST['description']) {
            $key = GetJWTSecret::getJWTSecret();
            $decodedToken = JWT::decode($token, new Key($key, 'HS256'));
            $id = $decodedToken->sub;
            $query = $pdo->prepare('INSERT INTO tasks (title, description, user_id) VALUES (:title, :description, :user_id)');
            if ($query->execute([
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'user_id' => $id
            ])) {
                echo json_encode(
                    [
                        'sucess' => 'Tarefa inserida com sucesso!'
                    ]
                );
            } else {
                echo json_encode([
                    'error' => 'Erro ao inserir tarefa no banco de dados'
                ]);
            }
        } else {
            echo json_encode([
                'error' => 'Token invalido ou informaçoes de tarefa nao passadas na requisicao'
            ]);
            http_response_code(401);
        }
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