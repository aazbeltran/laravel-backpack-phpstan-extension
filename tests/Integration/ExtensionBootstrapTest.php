<?php

namespace LaravelBackpackPhpstanExtension\Tests\Integration;

use LaravelBackpackPhpstanExtension\Tests\TestCase;

class ExtensionBootstrapTest extends TestCase
{
    public function test_bootstrap_file_exists(): void
    {
        $bootstrapPath = dirname(__DIR__, 2) . '/bootstrap.php';
        $this->assertFileExists($bootstrapPath, 'Bootstrap file should exist');
    }

    public function test_extension_neon_file_exists(): void
    {
        $neonPath = dirname(__DIR__, 2) . '/extension.neon';
        $this->assertFileExists($neonPath, 'Extension configuration file should exist');
    }

    public function test_extension_neon_contains_required_services(): void
    {
        $neonPath = dirname(__DIR__, 2) . '/extension.neon';
        $content = file_get_contents($neonPath);

        $this->assertStringContainsString('methodsClassReflectionExtension', $content);
        $this->assertStringContainsString('dynamicMethodReturnTypeExtension', $content);
        $this->assertStringContainsString('CrudFieldMethodsClassReflectionExtension', $content);
        $this->assertStringContainsString('CrudColumnMethodsClassReflectionExtension', $content);
    }

    public function test_extension_neon_includes_stubs(): void
    {
        $neonPath = dirname(__DIR__, 2) . '/extension.neon';
        $content = file_get_contents($neonPath);

        $this->assertStringContainsString('scanFiles:', $content);
        $this->assertStringContainsString('stubs/', $content);
    }

    public function test_extension_neon_includes_bootstrap(): void
    {
        $neonPath = dirname(__DIR__, 2) . '/extension.neon';
        $content = file_get_contents($neonPath);

        $this->assertStringContainsString('bootstrapFiles:', $content);
        $this->assertStringContainsString('bootstrap.php', $content);
    }

    public function test_all_extension_classes_exist(): void
    {
        $expectedClasses = [
            'LaravelBackpackPhpstanExtension\\Methods\\CrudFieldMethodsClassReflectionExtension',
            'LaravelBackpackPhpstanExtension\\Methods\\CrudColumnMethodsClassReflectionExtension',
            'LaravelBackpackPhpstanExtension\\Reflection\\CrudFieldMethodReflection',
            'LaravelBackpackPhpstanExtension\\Reflection\\CrudColumnMethodReflection',
            'LaravelBackpackPhpstanExtension\\ReturnTypes\\CrudFieldFluentReturnTypeExtension',
            'LaravelBackpackPhpstanExtension\\ReturnTypes\\CrudColumnFluentReturnTypeExtension',
        ];

        foreach ($expectedClasses as $class) {
            $this->assertTrue(
                class_exists($class),
                "Extension class {$class} should exist"
            );
        }
    }
}
