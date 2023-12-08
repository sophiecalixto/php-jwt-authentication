<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use SophieCalixto\JWTAuthAPI\Database\PDOConnection;

$pdo = PDOConnection::getConnection();

$query = $pdo->prepare('CREATE TABLE IF NOT EXISTS tokens (
    id SERIAL NOT NULL,
    token VARCHAR(255) NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
)');

if($query->execute())
{
    echo 'Tabela tokens criada com sucesso!';
}
else
{
    echo 'Erro ao criar tabela tokens!';
}