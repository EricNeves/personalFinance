<?php
    
namespace App\Infrasctructure\Http;
    
class Request
{
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    public function body(): array
    {
        $json = json_decode(file_get_contents('php://input'), true) ?? [];
        
        return match ($this->getMethod()) {
            'GET' => $_GET, 'POST', 'PUT', 'DELETE' => $json, default  => [],
        };
    }
}