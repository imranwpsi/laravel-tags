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
        )->withPivot('type');
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

        // Keep tag relations scoped by pivot type and always persist the type on attach.
        $syncPayload = $tagIds
            ->unique()
            ->mapWithKeys(fn (int $id) => [$id => ['type' => $type]])
            ->toArray();

        $this->tags()->wherePivot('type', $type)->sync($syncPayload);

        return $this;
    }

    public function scopeWithTags($query, $tags)
    {
        return $query->whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('id', (array) $tags);
        });
    }
}
