<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use SophieCalixto\JWTAuthAPI\Database\PDOConnection;

$pdo = PDOConnection::getConnection();

$query = $pdo->prepare('CREATE TABLE IF NOT EXISTS tasks (
    id SERIAL NOT NULL,
    title VARCHAR(255) NOT NULL,
    description VARCHAR(255) NOT NULL,
    user_id INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
)'
);

if($query->execute())
{
    echo 'Tabela tasks criada com sucesso!';
}
else
{
    echo 'Erro ao criar tabela tasks!';
}