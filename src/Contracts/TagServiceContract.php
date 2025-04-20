<?php

namespace Ihossain\LaravelTags\Contracts;

interface TagServiceContract
{
    public function getAllTags(string $type = null);
    public function getTagById(int $id);
    public function createTag(array $data);
    public function updateTag(int $id, array $data);
    public function deleteTag(int $id);
    public function getTagsForModel(string $modelType, int $modelId);
    public function syncModelTags(string $modelType, int $modelId, array $tags);
}