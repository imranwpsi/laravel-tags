<?php

namespace Ihossain\LaravelTags\Tests\Unit;

use Ihossain\LaravelTags\Models\Tag;
use Ihossain\LaravelTags\Tests\Models\Course;
use Ihossain\LaravelTags\Tests\TestCase;

class TagModelTest extends TestCase
{
    /** @test */
    public function it_can_create_a_tag()
    {
        $tag = Tag::create([
            'name' => 'Laravel',
            'slug' => 'laravel',
            'type' => 'course'
        ]);

        $this->assertDatabaseHas('tags', [
            'name' => 'Laravel',
            'slug' => 'laravel',
            'type' => 'course'
        ]);
    }

    /** @test */
    public function it_can_attach_tags_to_course()
    {
        $course = Course::create(['title' => 'Laravel Basics']);
        $tag = Tag::create(['name' => 'Laravel', 'slug' => 'laravel']);

        $course->tags()->attach($tag);

        $this->assertCount(1, $course->tags);
        $this->assertEquals('Laravel', $course->tags->first()->name);
    }

    /** @test */
    public function it_can_sync_tags_using_trait()
    {
        $course = Course::create(['title' => 'Laravel Advanced']);

        $course->syncTags(['Laravel', 'PHP'], 'course');

        $this->assertCount(2, $course->tags);
        $this->assertEquals(['Laravel', 'PHP'], $course->tags->pluck('name')->toArray());
    }
}