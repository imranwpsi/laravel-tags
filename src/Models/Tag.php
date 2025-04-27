<?php

namespace Ihossain\LaravelTags\Models;

use Ihossain\LaravelTags\Database\Factories\TagFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasFactory;

    // Add this to specify the factory location
    protected static function newFactory()
    {
        return TagFactory::new();
    }

    protected $fillable = ['name', 'slug', 'type', 'is_active'];

    public function courses(): MorphToMany
    {
        return $this->morphedByMany(
            config('laravel-tags.models.course'),
            'taggable',
            'taggables',
            'tag_id',
            'taggable_id'
        );
    }

    public function blogs(): MorphToMany
    {
        return $this->morphedByMany(
            config('laravel-tags.models.blog'),
            'taggable',
            'taggables',
            'tag_id',
            'taggable_id'
        );
    }
}