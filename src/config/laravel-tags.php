<?php

return [
    'models' => [
        'course' => \Modules\Course\Models\Course::class,
        'blog' => \App\Models\Blog::class,
    ],

    'route_prefix' => 'api/tags',

    'middleware' => ['api'],
];
