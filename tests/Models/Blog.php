<?php

namespace Ihossain\LaravelTags\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Ihossain\LaravelTags\Traits\HasTags;

class Blog extends Model
{
    use HasTags;

    protected $table = 'blogs';
    protected $fillable = ['title'];
}