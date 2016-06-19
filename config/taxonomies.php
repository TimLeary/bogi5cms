<?php

return [
    '_next_id' => 12, # Shows the next fix taxonomy id
    'language' => 1,
    'languages' => [
        'english' => ['id' => 2, 'language_id' => 1, 'iso_code' => 'en'],
        'german' => ['id' => 3, 'language_id' => 2, 'iso_code' => 'de'],
        'hungarian' => ['id' => 4, 'language_id' => 3, 'iso_code' => 'hu'],
    ],
    'default_language' => 'english',
    'document_type' => 5,
    'document_types' => [
        'navigation' => 6,
        'article_list' => 7,
        'article' => 8
    ],
    'document_description_type' => 9,
    'document_description_types' => [
        'short_description' => 10,
        'long_description'  => 11
    ]
];