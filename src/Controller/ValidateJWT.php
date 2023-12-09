<?php

namespace SophieCalixto\JWTAuthAPI\Controller;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use UnexpectedValueException;

class ValidateJWT
{
    public static function validateExists(): bool
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            echo json_encode([
                'error' => 'Token nao informado!'
            ]);
            http_response_code(401);
            return false;
        }

        return true;
    }

    public static function validate(string $token): bool|\stdClass
    {
        try {
            $key = GetJWTSecret::getJWTSecret();
            return JWT::decode($token, new Key($key, 'HS256'));
        } catch (InvalidTokenStructure | SignatureInvalidException | ExpiredException | UnexpectedValueException  $e) {
            return false;
        }
    }

}