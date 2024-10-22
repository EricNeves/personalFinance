<?php
    
namespace App\Infrasctructure\Http;

use App\Infrasctructure\Exceptions\ApplicationErrors\HttpBodyValidatorException;
    
class Request
{
    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return array
     */
    public function body(): array
    {
        $json = json_decode(file_get_contents('php://input'), true) ?? [];
        
        return match ($this->getMethod()) {
            'GET' => $_GET, 'POST', 'PUT', 'DELETE' => $json, default  => [],
        };
    }

    /**
     * @param array $fields
     * @return array
     * @throws HttpBodyValidatorException
     */
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

    /**
     * @param string $field
     * @param mixed $value
     * @param string $rule
     * @throws HttpBodyValidatorException
     * @return void
     */
    private function validateRules(string $field, mixed $value, string $rule): void
    {
        if ($rule === 'required' && empty(trim($value))) {
            throw new HttpBodyValidatorException("The field {$field} is required");
        }
        
        if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new HttpBodyValidatorException("The field {$field} is not a valid email");
        }
    }
}