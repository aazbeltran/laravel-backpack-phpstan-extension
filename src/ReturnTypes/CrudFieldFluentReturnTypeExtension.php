<?php

namespace LaravelBackpackPhpstanExtension\ReturnTypes;

use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Type;

/**
 * Return type extension for CrudField fluent interface methods.
 */
class CrudFieldFluentReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    public function getClass(): string
    {
        return 'Backpack\\CRUD\\app\\Library\\CrudPanel\\CrudField';
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        $className = $methodReflection->getDeclaringClass()->getName();

        // Support fluent interface for CrudField and its subclasses
        return $className === 'Backpack\\CRUD\\app\\Library\\CrudPanel\\CrudField' ||
               $methodReflection->getDeclaringClass()->isSubclassOf('Backpack\\CRUD\\app\\Library\\CrudPanel\\CrudField');
    }

    public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        \PhpParser\Node\Expr\MethodCall $methodCall,
        Scope $scope
    ): Type {
        // Return the same type as the object for fluent interface
        return $scope->getType($methodCall->var);
    }
}
