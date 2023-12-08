<?php

namespace SophieCalixto\JWTAuthAPI\Controller;

use SophieCalixto\JWTAuthAPI\Database\PDOConnection;

class RegisterController
{
    public static function register()
    {
        $pdo = PDOConnection::getConnection();
        $query = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        if($query->execute([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_ARGON2ID)
        ]))
        {
            echo json_encode([
                'message' => 'Usuario cadastrado com sucesso!'
            ]);
            http_response_code(201);
        }
        else
        {
            echo json_encode([
                'message' => 'Erro ao cadastrar usuario!'
            ]);
            http_response_code(500);
        }
    }
}