<?php

namespace Ihossain\LaravelTags\Helper;

class Helpers
{
    public static function getRouteName(): ?string
    {
        return request()->route()->getName() ? explode('.', request()->route()->getName())[0] : null;
    }

    public static function getModuleName(): string
    {
        return self::getRouteName() ? explode('-', self::getRouteName())[0] : 'course';
    }
}