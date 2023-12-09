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
        if(!ValidateJWT::validateExists())
        {
            return;
        }

        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $token = str_replace('Bearer ', '', $token);
        $pdo = PDOConnection::getConnection();
        $token = ValidateJWT::validate($token);

        if ($token) {
            $id = $token->sub;
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
        if(!ValidateJWT::validateExists())
        {
            return;
        }

        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $token = str_replace('Bearer ', '', $token);
        $token = ValidateJWT::validate($token);
        $pdo = PDOConnection::getConnection();

        $secureKey = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if ($token) {
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

    public static function store()
    {
        if(!ValidateJWT::validateExists())
        {
            return;
        }

        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $token = str_replace('Bearer ', '', $token);
        $token = ValidateJWT::validate($token);
        $pdo = PDOConnection::getConnection();

        if ($token && $_POST['title'] && $_POST['description']) {
            $id = $token->sub;
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
        if(!ValidateJWT::validateExists())
        {
            return;
        }

        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $token = str_replace('Bearer ', '', $token);
        $token = ValidateJWT::validate($token);
        $pdo = PDOConnection::getConnection();

        $inputJSON = file_get_contents("php://input");
        $inputData = json_decode($inputJSON, true);

        $secureKey = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if ($token && isset($inputData['title']) && isset($inputData['description'])) {
            $query = $pdo->prepare('UPDATE tasks SET title = :title, description = :description WHERE id = :id');
            if ($query->execute([
                'title' => $inputData['title'],
                'description' => $inputData['description'],
                'id' => $secureKey
            ])
            ) {
                echo json_encode(
                    [
                        "success" => "Tarefa atualizada com sucesso!"
                    ]
                );
            } else {
                echo json_encode([
                    'error' => 'Erro ao atualizar tarefa no banco de dados!'
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

    public static function destroy(int $id)
    {
        if(!ValidateJWT::validateExists())
        {
            return;
        }

        $token = $_SERVER['HTTP_AUTHORIZATION'];
        $token = str_replace('Bearer ', '', $token);
        $token = ValidateJWT::validate($token);
        $pdo = PDOConnection::getConnection();

        $secureKey = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if ($token) {
            $query = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
            if ($query->execute([
                'id' => $secureKey
            ])
            ) {
                echo json_encode(
                    [
                        "success" => "Tarefa deletada com sucesso!"
                    ]
                );
            } else {
                echo json_encode([
                    'error' => 'Erro ao deletar tarefa no banco de dados!'
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