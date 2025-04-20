<?php

return [
    'models' => [
        'course' => \App\Models\Course::class,
        'blog' => \App\Models\Blog::class,
    ],

    'route_prefix' => 'api/tags',

    'middleware' => ['api'],
];