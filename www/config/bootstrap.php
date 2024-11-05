<?php

use App\Infrasctructure\Http\Request;
use App\Infrasctructure\Http\Response;
use App\Infrasctructure\Http\ControllerDeps;

/**
 * Dispatches incoming requests to the route handler.
 *
 * @param array $routes - Array structure:
 * - 'method'      => http request method
 * - 'uri'         => /users/{id}/fetch
 * - 'controller'  => Controller class name
 * - 'action'      => The controller method to invoke
 * - 'middlewares' => List of middleware keys to execute
 * @param array $middlewares - config/middlewares.php - Key and Class Association
 * @return void
 */
function dispatch(array $routes, array $middlewares = []): void
{
    $url = $_GET['url'] ?? '/';
    
    $url !== '/' && $url = rtrim($url, '/');
    
    $routerFound = false;
    
    $response = new Response();
    $request = new Request();
    
    foreach ($routes as $route) {
        $pattern = '#^' . preg_replace('/{id}/', '([\w-]+)', $route['uri']) . '$#';
        
        if (preg_match($pattern, $url, $matches)) {
            array_shift($matches);
            
            $routerFound = true;
            
            if ($request->getMethod() !== $route['method']) {
                $response->json([
                    'message' => 'Method not allowed'
                ], 405);
            }
            
            $middlewaresKey = $route['middlewares'];

            if (!empty($middlewaresKey)) {
                handleMiddlewares($middlewaresKey, $middlewares, $route, $request, $response, $matches);
            } else {
                callController($route, $request, $response, $matches);
            }
        }
    }
    
    if (!$routerFound) {
        $response->json([
            'message' => 'Endpoint not found'
        ], 404);
    }
}

/**
 * @param array $middlewaresKey - $route['middlewares'] - Middlewares defined in route Route::post()->middlewares('auth', 'admin')
 * @param array $middlewares - config/middlewares.php - Key and Class Association
 * @param array $route
 * @param Request $request
 * @param Response $response
 * @param array $params
 * @return void
 */
function handleMiddlewares(array $middlewaresKey, array $middlewares, array $route, Request $request, Response $response, array $params): void
{
    foreach ($middlewaresKey as $middlewareKey) {
        if (array_key_exists($middlewareKey, $middlewares)) {
            $middlewareClass = $middlewares[$middlewareKey];
            $middleware = new $middlewareClass();
            
            $middleware->handle($request, $response, function ($req) {});
        }
    }
    
    callController($route, $request, $response, $params);
}

/**
 * Call controller and resolve dependencies
 *
 * @param array $route
 * @param Request $request
 * @param Response $response
 * @param array $params
 * @return void
 */
function callController(array $route, Request $request, Response $response, array $params): void
{
    $controllerClass = $route['controller'];
    $action          = $route['action'];
    
    $controllerWithDependencies = ControllerDeps::resolveDependencies($controllerClass);
    $controllerWithDependencies->$action($request, $response, $params);
}