<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use SophieCalixto\JWTAuthAPI\Database\PDOConnection;

$pdo = PDOConnection::getConnection();

$query = $pdo->prepare('CREATE TABLE IF NOT EXISTS users (
    id SERIAL NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
)');

if($query->execute())
{
    echo 'Tabela users criada com sucesso!';
}
else
{
    echo 'Erro ao criar tabela users!';
}