<?php

namespace Ihossain\LaravelTags\Traits;

use Ihossain\LaravelTags\Models\Tag;

trait HasTags
{
    public function tags()
    {
        return $this->morphToMany(
            Tag::class,
            'taggable',
            'taggables',
            'taggable_id',
            'tag_id'
        );
    }

    public function syncTags(array $tags, string $type = 'default')
    {
        $tagIds = collect($tags)->map(function ($tag) use ($type) {
            if (is_numeric($tag)) {
                return (int) $tag;
            }

            return Tag::firstOrCreate([
                'name' => $tag,
                'slug' => \Illuminate\Support\Str::slug($tag),
                'type' => $type,
            ])->id;
        });

        $this->tags()->wherePivot('type', $type)->sync($tagIds);

        return $this;
    }

    public function scopeWithTags($query, $tags)
    {
        return $query->whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('id', (array) $tags);
        });
    }
}