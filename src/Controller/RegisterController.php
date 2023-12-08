<?php

namespace SophieCalixto\JWTAuthAPI\Controller;

use SophieCalixto\JWTAuthAPI\Database\PDOConnection;

class RegisterController
{
    public static function register(): void
    {
        $pdo = PDOConnection::getConnection();
        $query = $pdo->prepare('INSERT INTO users (name, email, password) VALUES (:name, :email, :password)');
        // verifica se o email já existe
        $verifyEmail = $pdo->prepare('SELECT * FROM users WHERE email = :email');
        $verifyEmail->execute([
            'email' => $_POST['email']
        ]);
        if($verifyEmail->rowCount() > 0)
        {
            echo json_encode([
                'message' => 'Email ja cadastrado!'
            ]);
            http_response_code(400);
            exit();
        }

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