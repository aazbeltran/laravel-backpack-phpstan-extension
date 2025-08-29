<?php

namespace LaravelBackpackPhpstanExtension\Tests\Integration;

use LaravelBackpackPhpstanExtension\Tests\TestCase;

class CrudColumnTest extends TestCase
{
    public function test_crud_column_methods_exist_in_extension(): void
    {
        $extensionClass = 'LaravelBackpackPhpstanExtension\\Methods\\CrudColumnMethodsClassReflectionExtension';
        $this->assertTrue(class_exists($extensionClass), 'CrudColumn extension class should exist');

        $extension = new $extensionClass();
        $this->assertInstanceOf($extensionClass, $extension);
    }

    public function test_crud_column_method_reflection_exists(): void
    {
        $reflectionClass = 'LaravelBackpackPhpstanExtension\\Reflection\\CrudColumnMethodReflection';
        $this->assertTrue(class_exists($reflectionClass), 'CrudColumn method reflection class should exist');
    }

    public function test_crud_column_return_type_extension_exists(): void
    {
        $returnTypeClass = 'LaravelBackpackPhpstanExtension\\ReturnTypes\\CrudColumnFluentReturnTypeExtension';
        $this->assertTrue(class_exists($returnTypeClass), 'CrudColumn return type extension class should exist');

        $extension = new $returnTypeClass();
        $this->assertInstanceOf($returnTypeClass, $extension);
    }

    public function test_crud_column_stub_contains_expected_content(): void
    {
        $this->assertStubExists('CrudColumn.stub');

        // Validate stub content using assertStubContains helper
        $this->assertStubContains('CrudColumn.stub', 'class CrudColumn');
        $this->assertStubContains('CrudColumn.stub', 'public function type(');
        $this->assertStubContains('CrudColumn.stub', 'public function label(');
        $this->assertStubContains('CrudColumn.stub', 'public function searchable(');
        $this->assertStubContains('CrudColumn.stub', 'public function orderable(');
    }

    public function test_crud_column_stub_has_fluent_interface(): void
    {
        // Check that methods return $this for fluent interface
        $this->assertStubContains('CrudColumn.stub', 'return $this;');

        // Check that the class exists in the proper namespace
        $this->assertStubContains('CrudColumn.stub', 'namespace Backpack\\CRUD\\app\\Library\\CrudPanel;');
    }
}
