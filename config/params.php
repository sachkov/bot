<?php

return [
    'default' => [
        'pray_length' => 7,
    ],
    'list' => [
        'limit' => 5,
        'default_order' => 'created_at',
        'cache_ttl' => 12*60*60,
    ],
    'edit' => [
        'limit' => 4,
        'default_order' => 'created_at',
        'cache_ttl' => 6*60*60,
    ],
];
