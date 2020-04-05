<?php

return [
    'conversions' => [
        [
            'name'         => 'web',
            'manipulation' => 'fit',
            'width'        => 800,
            'height'       => 1800,
            'title'        => true,
            'post'         => true,
            'optimize'     => true,
        ],
        [
            'name'         => 'thumb',
            'manipulation' => 'crop',
            'width'        => 400,
            'height'       => 300,
            'title'        => true,
            'post'         => true,
            'optimize'     => true,
        ],
        [
            'name'         => 'banner',
            'manipulation' => 'fit',
            'width'        => 1400,
            'height'       => 1000,
            'title'        => true,
            'post'         => false,
            'optimize'     => true,
        ],
    ],
    'media-broker' => \Dymantic\SmlMediaBroker\SmlMediaBroker::class,
    'upload-response-src' => [
        'title' => 'banner',
        'post' => 'web',
    ],
];
