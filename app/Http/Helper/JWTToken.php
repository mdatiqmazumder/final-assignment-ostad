<?php

namespace App\Http\Helper;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken{

    public static function createToken($email,$id){
        $key = env('JWT_SECRET');
        $payload = array(
            "iss" => "laravel-token",
            "email" => $email,
            "user_id" => $id,
            "iat" => time(),
            "exp" => time() + 60*60*24*30
        );
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }

    public static function verifyToken($token){
        $key = env('JWT_SECRET');
        try{
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            return [
                'email' => $decoded->email,
                'user_id' => $decoded->user_id
            ];
        }catch(\Exception $e){
            return 'unauthorized';
        }
    }


}
