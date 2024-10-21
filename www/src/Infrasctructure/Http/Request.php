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
    
    public function validate(array $fields): array
    {
        foreach ($fields as $field => $rules) {
            $value = $this->body()[$field] ?? '';
            
            foreach (explode("|", $rules) as $rule) {
                $this->validateRules($field, $rule, $value);
            }
        }
        
        return $this->body();
    }
    
    private function validateRules(string $field, mixed $value, string $rule): void
    {
        if ($rule === "required" && is_null($value)) {
            throw new \Exception("The field {$field} is required");
        }
        
        if ($rule === "email" && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("The field {$field} is not a valid email");
        }
    }
}