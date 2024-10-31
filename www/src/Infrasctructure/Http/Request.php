<?php
    
namespace App\Infrasctructure\Http;

use App\Domain\Entities\UserContext;
use App\Infrasctructure\Exceptions\ApplicationErrors\HttpBodyValidatorException;
use App\Infrasctructure\Exceptions\ApplicationErrors\UnauthorizedException;

class Request
{
    private UserContext $user;
    
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    
    public function body(): array
    {
        $json = json_decode(file_get_contents('php://input'), true);
        
        return match ($this->getMethod()) {
            'GET' => $_GET,
            'POST' => $json ?? $_POST,
            'PUT', 'DELETE' => $json,
            default => [],
        };
    }

    public function validate(array $fields): array
    {
        foreach ($fields as $field => $rules) {
            $value = $this->body()[$field] ?? '';
            
            foreach (explode("|", $rules) as $rule) {
                $this->validateRules($field, $value, $rule);
            }
        }
        
        return $this->body();
    }
    
    private function validateRules(string $field, mixed $value, string $rule): void
    {
        if ($rule === 'required' && is_string($value) && empty(trim($value))) {
            throw new HttpBodyValidatorException("The field {$field} is required");
        }
        
        if ($rule === 'email' && is_string($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new HttpBodyValidatorException("The field {$field} is not a valid email");
        }
        
        if ($rule === 'numeric' && !is_numeric($value)) {
            throw new HttpBodyValidatorException("The field {$field} must be an number");
        }
    }

    public function bearerToken(): string
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            throw new UnauthorizedException('Please, provide a bearer token', 401);
        }

        $tokenPartials = explode(' ', $headers['Authorization']);

        if (count($tokenPartials) !== 2 || $tokenPartials[0] !== 'Bearer') {
            throw new UnauthorizedException('Please, provide a bearer token', 401);
        }

        return $tokenPartials[1];
    }

    public function setUser(UserContext $user): void
    {
        $this->user = $user;
    }

    public function user(): UserContext
    {
        return $this->user;
    }
}