<?php

namespace LaravelBackpackPhpstanExtension\Methods;

use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use LaravelBackpackPhpstanExtension\Reflection\CrudFieldMethodReflection;

/**
 * PHPStan extension for CrudField magic methods
 */
class CrudFieldMethodsClassReflectionExtension implements MethodsClassReflectionExtension
{
    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        if (!$this->isCrudFieldClass($classReflection)) {
            return false;
        }

        // Allow all method calls on CrudField (fluent interface)
        return true;
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        return new CrudFieldMethodReflection($classReflection, $methodName);
    }

    private function isCrudFieldClass(ClassReflection $classReflection): bool
    {
        return $classReflection->getName() === 'Backpack\\CRUD\\app\\Library\\CrudPanel\\CrudField' ||
               $classReflection->isSubclassOf('Backpack\\CRUD\\app\\Library\\CrudPanel\\CrudField');
    }
}