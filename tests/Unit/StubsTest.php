<?php

namespace LaravelBackpackPhpstanExtension\Tests\Unit;

use LaravelBackpackPhpstanExtension\Tests\TestCase;

class StubsTest extends TestCase
{
    public function test_core_stubs_exist(): void
    {
        $coreStubs = [
            'CrudPanel.stub',
            'CrudField.stub',
            'CrudColumn.stub',
            'CrudFilter.stub',
            'Widget.stub',
            'CrudController.stub',
            'CrudPanelFacade.stub',
            'LaravelFacades.stub',
        ];

        foreach ($coreStubs as $stub) {
            $this->assertStubExists($stub);
        }
    }

    public function test_pro_stubs_exist(): void
    {
        $proStubs = [
            'Pro/CloneOperation.stub',
            'Pro/FetchOperation.stub',
            'Pro/InlineCreateOperation.stub',
            'Pro/ChartController.stub',
        ];

        foreach ($proStubs as $stub) {
            $this->assertStubExists($stub);
        }
    }

    public function test_crud_panel_stub_contains_essential_methods(): void
    {
        $this->assertStubContains('CrudPanel.stub', 'addField');
        $this->assertStubContains('CrudPanel.stub', 'addColumn');
        $this->assertStubContains('CrudPanel.stub', 'addFilter');
        $this->assertStubContains('CrudPanel.stub', 'addButton');
        $this->assertStubContains('CrudPanel.stub', 'setModel');
        $this->assertStubContains('CrudPanel.stub', 'setRoute');
    }

    public function test_crud_field_stub_contains_magic_methods(): void
    {
        // Check for explicit method declarations (better than @method annotations)
        $this->assertStubContains('CrudField.stub', 'public function type(');
        $this->assertStubContains('CrudField.stub', 'public function label(');
        $this->assertStubContains('CrudField.stub', 'public function required(');
        $this->assertStubContains('CrudField.stub', 'public function __call(');
    }

    public function test_crud_column_stub_contains_magic_methods(): void
    {
        // Check for explicit method declarations (better than @method annotations)
        $this->assertStubContains('CrudColumn.stub', 'public function type(');
        $this->assertStubContains('CrudColumn.stub', 'public function label(');
        $this->assertStubContains('CrudColumn.stub', 'public function searchable(');
        $this->assertStubContains('CrudColumn.stub', 'public function __call(');
    }

    public function test_crud_filter_stub_contains_properties(): void
    {
        $this->assertStubContains('CrudFilter.stub', 'public $name');
        $this->assertStubContains('CrudFilter.stub', 'public $type');
        $this->assertStubContains('CrudFilter.stub', 'public $values');
    }

    public function test_laravel_facades_stub_contains_common_facades(): void
    {
        $facades = ['Request', 'Route', 'Schema', 'Auth', 'Artisan', 'Alert'];

        foreach ($facades as $facade) {
            $this->assertStubContains('LaravelFacades.stub', "class {$facade}");
        }
    }

    public function test_pro_operation_stubs_contain_method_signatures(): void
    {
        // Check for @method annotations (Pro stubs use this format)
        $this->assertStubContains('Pro/CloneOperation.stub', '@method');
        $this->assertStubContains('Pro/CloneOperation.stub', 'clone()');
        $this->assertStubContains('Pro/CloneOperation.stub', 'setupCloneOperation()');

        $this->assertStubContains('Pro/FetchOperation.stub', '@method');
        $this->assertStubContains('Pro/FetchOperation.stub', 'fetch()');
        $this->assertStubContains('Pro/FetchOperation.stub', 'setupFetchOperation()');

        $this->assertStubContains('Pro/InlineCreateOperation.stub', '@method');
        $this->assertStubContains('Pro/InlineCreateOperation.stub', 'inlineCreate()');
        $this->assertStubContains('Pro/InlineCreateOperation.stub', 'setupInlineCreateOperation()');
    }
}
