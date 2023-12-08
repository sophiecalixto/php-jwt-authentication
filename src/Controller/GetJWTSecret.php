<?php

namespace SophieCalixto\JWTAuthAPI\Controller;

class GetJWTSecret
{
    public static function getJWTSecret(): string
    {
        $envContents = file_get_contents(__DIR__ . '/../../.env');
        $envArray = parse_ini_string($envContents, false, INI_SCANNER_RAW);
        return $envArray["JWT_SECRET"];
    }
}