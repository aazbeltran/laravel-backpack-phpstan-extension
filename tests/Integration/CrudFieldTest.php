<?php

namespace LaravelBackpackPhpstanExtension\Tests\Integration;

use LaravelBackpackPhpstanExtension\Tests\TestCase;

class CrudFieldTest extends TestCase
{
    public function test_crud_field_methods_exist_in_extension(): void
    {
        $extensionClass = 'LaravelBackpackPhpstanExtension\\Methods\\CrudFieldMethodsClassReflectionExtension';
        $this->assertTrue(class_exists($extensionClass), 'CrudField extension class should exist');
        
        $extension = new $extensionClass();
        $this->assertInstanceOf($extensionClass, $extension);
    }

    public function test_crud_field_method_reflection_exists(): void
    {
        $reflectionClass = 'LaravelBackpackPhpstanExtension\\Reflection\\CrudFieldMethodReflection';
        $this->assertTrue(class_exists($reflectionClass), 'CrudField method reflection class should exist');
    }

    public function test_crud_field_return_type_extension_exists(): void
    {
        $returnTypeClass = 'LaravelBackpackPhpstanExtension\\ReturnTypes\\CrudFieldFluentReturnTypeExtension';
        $this->assertTrue(class_exists($returnTypeClass), 'CrudField return type extension class should exist');
        
        $extension = new $returnTypeClass();
        $this->assertInstanceOf($returnTypeClass, $extension);
    }

    public function test_crud_field_stub_contains_expected_content(): void
    {
        $this->assertStubExists('CrudField.stub');
        
        // Validate stub content using assertStubContains helper
        $this->assertStubContains('CrudField.stub', 'class CrudField');
        $this->assertStubContains('CrudField.stub', 'public function type(');
        $this->assertStubContains('CrudField.stub', 'public function label(');
        $this->assertStubContains('CrudField.stub', 'public function required(');
        $this->assertStubContains('CrudField.stub', 'public function default(');
    }

    public function test_crud_field_stub_has_fluent_interface(): void
    {
        // Check that methods return $this for fluent interface
        $this->assertStubContains('CrudField.stub', 'return $this;');
        
        // Check that the class exists in the proper namespace
        $this->assertStubContains('CrudField.stub', 'namespace Backpack\\CRUD\\app\\Library\\CrudPanel;');
    }
}