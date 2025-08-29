<?php

namespace LaravelBackpackPhpstanExtension\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

class TestArticleModel extends Model
{
    protected $table = 'articles';
    
    protected $fillable = [
        'title', 
        'content', 
        'status'
    ];
    
    /** @var array<string,string> */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}