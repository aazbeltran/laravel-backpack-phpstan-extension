<?php

namespace LaravelBackpackPhpstanExtension\Tests\Integration;

use LaravelBackpackPhpstanExtension\Tests\TestCase;

class ProPackageTest extends TestCase
{
    public function test_pro_operation_stubs_exist(): void
    {
        $proStubs = [
            'Pro/CloneOperation.stub',
            'Pro/FetchOperation.stub',
            'Pro/InlineCreateOperation.stub',
        ];

        foreach ($proStubs as $stub) {
            $this->assertStubExists($stub, "Pro stub {$stub} should exist");
        }
    }

    public function test_pro_controller_stub_exists(): void
    {
        $this->assertStubExists('Pro/ChartController.stub');

        // Validate stub content using assertStubContains helper
        $this->assertStubContains('Pro/ChartController.stub', 'class ChartController');
        $this->assertStubContains('Pro/ChartController.stub', 'namespace Backpack\\Pro\\Http\\Controllers');
    }

    public function test_clone_operation_stub_content(): void
    {
        // Validate stub content using assertStubContains helper
        $this->assertStubContains('Pro/CloneOperation.stub', 'trait CloneOperation');
        $this->assertStubContains('Pro/CloneOperation.stub', 'namespace Backpack\\Pro\\Http\\Controllers\\Operations');
        $this->assertStubContains('Pro/CloneOperation.stub', 'clone()');
        $this->assertStubContains('Pro/CloneOperation.stub', 'setupCloneOperation()');
    }

    public function test_fetch_operation_stub_content(): void
    {
        // Validate stub content using assertStubContains helper
        $this->assertStubContains('Pro/FetchOperation.stub', 'trait FetchOperation');
        $this->assertStubContains('Pro/FetchOperation.stub', 'namespace Backpack\\Pro\\Http\\Controllers\\Operations');
        $this->assertStubContains('Pro/FetchOperation.stub', 'fetch()');
        $this->assertStubContains('Pro/FetchOperation.stub', 'setupFetchOperation()');
    }

    public function test_inline_create_operation_stub_content(): void
    {
        // Validate stub content using assertStubContains helper
        $this->assertStubContains('Pro/InlineCreateOperation.stub', 'trait InlineCreateOperation');
        $this->assertStubContains('Pro/InlineCreateOperation.stub', 'namespace Backpack\\Pro\\Http\\Controllers\\Operations');
        $this->assertStubContains('Pro/InlineCreateOperation.stub', 'inlineCreate()');
        $this->assertStubContains('Pro/InlineCreateOperation.stub', 'setupInlineCreateOperation()');
    }

    public function test_pro_stubs_directory_structure(): void
    {
        $stubsDir = dirname(__DIR__, 2) . '/stubs';
        $proDir = $stubsDir . '/Pro';

        $this->assertDirectoryExists($proDir, 'Pro stubs directory should exist');

        $proFiles = glob($proDir . '/*.stub');
        $this->assertGreaterThan(0, count($proFiles), 'Pro directory should contain stub files');
    }
}
