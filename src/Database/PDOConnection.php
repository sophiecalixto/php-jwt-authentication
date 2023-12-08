<?php

namespace SophieCalixto\JWTAuthAPI\Database;

use PDO;

class PDOConnection
{
    public static function getConnection() : PDO
    {
        $envContents = file_get_contents(__DIR__ . '/../../.env');
        $envArray = parse_ini_string($envContents, false, INI_SCANNER_RAW);
        $driver = $envArray["DB_DRIVER"];
        $host = $envArray["DB_HOST"];
        $port =  $envArray["DB_PORT"];
        $dbname =  $envArray["DB_NAME"];
        $user =  $envArray["DB_USER"];
        $password = $envArray["DB_PASSWORD"];

        return new PDO("$driver:host=$host;port=$port;dbname=$dbname", $user, $password);
    }
}