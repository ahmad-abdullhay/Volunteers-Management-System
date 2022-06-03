<?php

return [
    'type_to_class' => [
        1 => \App\Models\User::class,
        2 => \App\Models\Event::class,
        3 => \App\Models\Badge::class,
    ],
    'class_to_type' => [
        \App\Models\User::class => 1,
        \App\Models\Event::class => 2,
        \App\Models\Badge::class => 3
    ]

];
