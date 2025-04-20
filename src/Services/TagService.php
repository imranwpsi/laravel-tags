<?php

namespace Ihossain\LaravelTags\Services;

use Ihossain\LaravelTags\Contracts\TagServiceContract;
use Ihossain\LaravelTags\Models\Tag;

class TagService implements TagServiceContract
{
    public function getAllTags(string $type = null)
    {
        $query = Tag::query();

        if ($type) {
            $query->where('type', $type);
        }

        return $query->get();
    }

    public function getTagById(int $id)
    {
        return Tag::findOrFail($id);
    }

    public function createTag(array $data)
    {
        return Tag::create($data);
    }

    public function updateTag(int $id, array $data)
    {
        $tag = $this->getTagById($id);
        $tag->update($data);
        return $tag;
    }

    public function deleteTag(int $id)
    {
        $tag = $this->getTagById($id);
        return $tag->delete();
    }

    public function getTagsForModel(string $modelType, int $modelId)
    {
        $modelClass = config("laravel-tags.models.{$modelType}");

        if (!class_exists($modelClass)) {
            throw new \InvalidArgumentException("Model {$modelType} not configured");
        }

        $model = $modelClass::findOrFail($modelId);
        return $model->tags;
    }

    public function syncModelTags(string $modelType, int $modelId, array $tags)
    {
        $modelClass = config("laravel-tags.models.{$modelType}");

        if (!class_exists($modelClass)) {
            throw new \InvalidArgumentException("Model {$modelType} not configured");
        }

        $model = $modelClass::findOrFail($modelId);
        $model->syncTags($tags, $modelType);
        return $model->tags;
    }
}