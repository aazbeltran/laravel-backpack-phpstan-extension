<?php

namespace LaravelBackpackPhpstanExtension\Tests\Fixtures;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class TestCrudController extends CrudController
{
    public function setup(): void
    {
        // Test field magic methods
        CRUD::field('name')
            ->type('text')
            ->label('Full Name')
            ->required()
            ->save();

        // Test column magic methods
        CRUD::column('email')
            ->type('email')
            ->label('Email Address')
            ->searchable()
            ->save();

        // Test filter magic methods
        CRUD::filter('status')
            ->type('dropdown')
            ->values(['active', 'inactive'])
            ->save();

        // Test fluent interface chaining
        $field = CRUD::field('description')->type('textarea')->required();
        $column = CRUD::column('created_at')->type('datetime')->searchable();
        $filter = CRUD::filter('category')->type('select');
    }

    public function setupListOperation(): void
    {
        CRUD::addColumn(['name' => 'title', 'type' => 'text']);
        CRUD::addColumn(['name' => 'status', 'type' => 'select']);
    }

    public function setupCreateOperation(): void
    {
        CRUD::addField(['name' => 'title', 'type' => 'text']);
        CRUD::addField(['name' => 'content', 'type' => 'wysiwyg']);
    }
}
