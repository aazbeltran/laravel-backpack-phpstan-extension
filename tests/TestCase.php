<?php

namespace LaravelBackpackPhpstanExtension\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getFixturePath(string $path = ''): string
    {
        return __DIR__ . '/fixtures' . ($path ? '/' . ltrim($path, '/') : '');
    }

    protected function getStubPath(string $stub): string
    {
        return dirname(__DIR__) . '/stubs/' . $stub;
    }

    protected function assertStubExists(string $stub): void
    {
        $this->assertFileExists($this->getStubPath($stub), "Stub file '{$stub}' should exist");
    }

    protected function assertStubContains(string $stub, string $content): void
    {
        $this->assertStubExists($stub);
        $stubContent = file_get_contents($this->getStubPath($stub));
        $this->assertStringContainsString($content, $stubContent, "Stub '{$stub}' should contain '{$content}'");
    }
}
