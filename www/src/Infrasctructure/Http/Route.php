<?php

namespace App\Infrasctructure\Http;

class Route
{
    private static array $routes = [];

    public function __construct(
        private readonly string $method,
        private readonly string $uri,
        private readonly array $controllerWithAction,
        private readonly array $middlewares = []
    )
    {
        $this->register();
    }

    public static function get(string $uri, array $controllerWithAction = []): self
    {
        return new self('GET', $uri, $controllerWithAction);
    }

    public static function post(string $uri, array $controllerWithAction = []): self
    {
        return new self('POST', $uri, $controllerWithAction);
    }

    public static function put(string $uri, array $controllerWithAction = []): self
    {
        return new self('PUT', $uri, $controllerWithAction);
    }
    
    public static function delete(string $uri, array $controllerWithAction = []): self
    {
        return new self('DELETE', $uri, $controllerWithAction);
    }
    
    private function register(): void
    {
        self::$routes[] = [
            'method'      => $this->method,
            'uri'         => $this->uri,
            'controller'  => $this->controllerWithAction[0],
            'action'      => $this->controllerWithAction[1],
            'middlewares' => $this->middlewares
        ];
    }

    public function middlewares(string ...$middlewares): self
    {
        array_pop(self::$routes);
        return new self($this->method, $this->uri, $this->controllerWithAction, $middlewares);
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }
}