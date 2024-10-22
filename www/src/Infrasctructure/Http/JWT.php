<?php

namespace App\Infrasctructure\Http;

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
        return hash_hmac('sha256', "$headerEncoded.$payloadEncoded", $_ENV['JWT_SECRET_KEY'], true);
    }
    
    public static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    public static function base64UrlDecode(string $data): string
    {
        $padding = strlen($data) % 4;
        
        $padding !== 0 && $data .= str_repeat('=', 4 - $padding);
        
        return base64_decode(strtr($data, '-_', '+/'));
    }
}