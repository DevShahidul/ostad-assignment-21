<?php

namespace App\Helper;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken {
    public static function CreateToken($email):string{
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'laravel-token',
            // 'aud' => 'http://example.com',
            'iat' => time(),
            'exp' => time()+60*60,
            'email' => $email
        ];

        return JWT::encode($payload, $key, 'HS256');
    }

    public static function VerifyToken($token):string{
        try{
            $key = env('JWT_KEY');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            return $decoded->userEmail;
        }
        catch(Exception $e){
            return "Unauthorized";
        }
    }
}
