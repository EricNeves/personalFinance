<?php

namespace App\Infrasctructure\Http;

use ReflectionClass;
use ReflectionException;

class ControllerDeps
{
    public static function resolveDependencies(string $className)
    {
        $reflectionClass = new ReflectionClass($className);

        $constructor = $reflectionClass->getConstructor();
        
        if (!$constructor) {
            return $reflectionClass->newInstance();
        }
        
        $parameters = $constructor->getParameters();
        
        $dependencies = [];
        
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType()->getName();
            
            $dependencies[] = new $dependency();
        }
        
        return $reflectionClass->newInstanceArgs($dependencies);
    }
}