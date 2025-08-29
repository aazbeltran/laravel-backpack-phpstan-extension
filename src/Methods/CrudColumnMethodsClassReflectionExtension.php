<?php

namespace LaravelBackpackPhpstanExtension\Methods;

use LaravelBackpackPhpstanExtension\Reflection\CrudColumnMethodReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;

/**
 * PHPStan extension for CrudColumn magic methods.
 */
class CrudColumnMethodsClassReflectionExtension implements MethodsClassReflectionExtension
{
    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        if (!$this->isCrudColumnClass($classReflection)) {
            return false;
        }

        // Allow all method calls on CrudColumn (fluent interface)
        return true;
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        return new CrudColumnMethodReflection($classReflection, $methodName);
    }

    private function isCrudColumnClass(ClassReflection $classReflection): bool
    {
        return $classReflection->getName() === 'Backpack\\CRUD\\app\\Library\\CrudPanel\\CrudColumn' ||
               $classReflection->isSubclassOf('Backpack\\CRUD\\app\\Library\\CrudPanel\\CrudColumn');
    }
}
