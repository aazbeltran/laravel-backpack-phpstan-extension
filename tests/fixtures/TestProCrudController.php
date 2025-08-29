<?php

namespace LaravelBackpackPhpstanExtension\Tests\Fixtures;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\Pro\Http\Controllers\Operations\CloneOperation;
use Backpack\Pro\Http\Controllers\Operations\FetchOperation;
use Backpack\Pro\Http\Controllers\Operations\InlineCreateOperation;

class TestProCrudController extends CrudController
{
    use CloneOperation, FetchOperation, InlineCreateOperation;

    public function setup()
    {
        $this->crud->setModel(TestArticleModel::class);
        $this->crud->setRoute('admin/article');
        
        // Test Pro operations
        $this->crud->clone();
        $this->crud->fetch();
        $this->crud->inlineCreate();
    }

    public function setupCloneOperation()
    {
        $this->crud->clone(['title', 'content']);
    }

    public function setupFetchOperation()
    {
        $this->crud->fetch(['title', 'status']);
    }
}