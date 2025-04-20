<?php

namespace Ihossain\LaravelTags\Tests\Unit;

use Ihossain\LaravelTags\Contracts\TagServiceContract;
use Ihossain\LaravelTags\Models\Tag;
use Ihossain\LaravelTags\Tests\Models\Course;
use Ihossain\LaravelTags\Tests\TestCase;

class TagServiceTest extends TestCase
{
    protected $tagService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tagService = app(TagServiceContract::class);
    }

    /** @test */
    public function it_can_get_all_tags()
    {
        Tag::factory()->count(3)->create();

        $tags = $this->tagService->getAllTags();

        $this->assertCount(3, $tags);
    }

    /** @test */
    public function it_can_filter_tags_by_type()
    {
        Tag::factory()->create(['type' => 'course']);
        Tag::factory()->create(['type' => 'blog']);
        Tag::factory()->create(['type' => 'course']);

        $courseTags = $this->tagService->getAllTags('course');
        $blogTags = $this->tagService->getAllTags('blog');

        $this->assertCount(2, $courseTags);
        $this->assertCount(1, $blogTags);
    }

    /** @test */
    public function it_can_create_a_tag()
    {
        $tag = $this->tagService->createTag([
            'name' => 'New Tag',
            'slug' => 'new-tag',
            'type' => 'course'
        ]);

        $this->assertDatabaseHas('tags', [
            'name' => 'New Tag',
            'slug' => 'new-tag'
        ]);
    }

    /** @test */
    public function it_can_sync_tags_for_model()
    {
        $course = Course::create(['title' => 'Test Course']);

        $tags = $this->tagService->syncModelTags('course', $course->id, ['Tag1', 'Tag2']);

        $this->assertCount(2, $tags);
        $this->assertEquals(['Tag1', 'Tag2'], $tags->pluck('name')->toArray());
    }
}