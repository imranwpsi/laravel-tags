<?php

namespace Ihossain\LaravelTags\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Ihossain\LaravelTags\Traits\HasTags;

class Course extends Model
{
    use HasTags;

    protected $table = 'courses';
    protected $fillable = ['title'];
}