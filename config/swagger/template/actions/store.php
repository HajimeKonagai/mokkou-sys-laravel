<?php

return [
    'summary' => 'Create a new {MODEL_NAME}',
    'operationId' => '',
    'tags' => [],
    'requestBody' => [
        'required' => true,
        'content' => [
            'application/json' => [
                'schema' => [
                    '$ref' => '#/components/schemas/{MODEL_NAME}',
                ],
                'example' => [],
            ],
        ],
    ],
    'responses' => [
        '201' => [
            'description' => '{MODEL_NAME} created successfully',
            'content' => [
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/{MODEL_NAME}',
                    ],
                ],
            ],
        ],
    ],
];