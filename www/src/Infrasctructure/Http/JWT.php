<?php

namespace App\Infrasctructure\Http;

use App\Domain\Entities\UserContext;
use stdClass;

class JWT
{
    public static function sign(mixed $payload = []): string
    {
        $header  = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode($payload);
        
        $header_encoded    = self::base64UrlEncode($header);
        $payload_encoded   = self::base64UrlEncode($payload);
        $signature_encoded = self::base64UrlEncode(self::signature($header_encoded, $payload_encoded));
        
        return "$header_encoded.$payload_encoded.$signature_encoded";
    }
    
    public static function signature(string $headerEncoded, string $payloadEncoded): string
    {
        $sign = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", $_ENV['JWT_SECRET_KEY'], true);

        return self::base64UrlEncode($sign);
    }
    
    public static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    public static function base64UrlDecode(string $data): UserContext
    {
        $padding = strlen($data) % 4;

        $padding !== 0 && $data .= str_repeat('=', 4 - $padding);

        $dataFromToken = json_decode(base64_decode(strtr($data, '-_', '+/')));
        
        return new UserContext($dataFromToken->id, $dataFromToken->email);
    }

    public static function validate(string $token): bool | UserContext
    {
        $tokenPartials = explode('.', $token);

        if (count($tokenPartials) !== 3) {
            return false;
        }

        [$header_encoded, $payload_encoded, $signature] = $tokenPartials;

        if ($signature !== self::signature($header_encoded, $payload_encoded)) {
            return false;
        }

        return self::base64UrlDecode($payload_encoded);
    }
}