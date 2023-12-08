<?php

namespace SophieCalixto\JWTAuthAPI\Controller;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use SophieCalixto\JWTAuthAPI\Database\PDOConnection;

class LoginController
{
    public static function login(): void
    {
        $pdo = PDOConnection::getConnection();
        $query = $pdo->prepare('SELECT * FROM users WHERE email = :email');
        $query->execute([
            'email' => $_POST['email']
        ]);
        $user = $query->fetch(\PDO::FETCH_ASSOC);
        if($user)
        {
            if(password_verify($_POST['password'], $user['password']))
            {
                $token = GetJWTSecret::getJWTSecret();
                $payload = [
                    'iss' => 'localhost',
                    'sub' => $user['id'],
                    'iat' => time(),
                    'exp' => time() + (60 * 60 * 24)
                ];
                $token = JWT::encode($payload, $token, 'HS256');
                $query = $pdo->prepare('INSERT INTO tokens (token, user_id) VALUES (:token, :user_id)');

                // VERIFY IF TOKEN ALREADY EXISTS AND IF IT IS VALID
                $verifyQuery = $pdo->prepare('SELECT * FROM tokens WHERE user_id = :user_id');
                $verifyQuery->execute([
                    'user_id' => $user['id']
                ]);
                $verifyToken = $verifyQuery->fetch(\PDO::FETCH_ASSOC);
                if($verifyToken)
                {
                    $decodedToken = JWT::decode($verifyToken['token'], new Key(GetJWTSecret::getJWTSecret(), 'HS256'));
                    if($decodedToken)
                    {
                        echo json_encode([
                            'token' => $verifyToken['token']
                        ]);
                        http_response_code(200);
                        return;
                    }
                }
                // END OF VERIFY

                if($query->execute([
                    'token' => $token,
                    'user_id' => $user['id']
                ]))
                {
                    echo json_encode([
                        'token' => $token
                    ]);
                    http_response_code(200);
                }
                else
                {
                    echo json_encode([
                        'message' => 'Erro ao gerar token!'
                    ]);
                    http_response_code(500);
                }
            }
            else
            {
                echo json_encode([
                    'message' => 'Senha incorreta!'
                ]);
                http_response_code(400);
            }
        }
        else
        {
            echo json_encode([
                'message' => 'Email nao cadastrado!'
            ]);
            http_response_code(400);
        }
    }
}