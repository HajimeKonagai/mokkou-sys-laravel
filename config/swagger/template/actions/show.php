<?php

return [
    'summary' => 'Get a {MODEL_NAME} by id',
    'operationId' => '',
    'tags' => [ ],
    'parameters' => [
        [
            'name' => 'id',
            'in' => 'path',
            'required' => true,
            'schema' => [
                'type' => 'integer',
            ],
        ]
    ],
    'responses' => [
        '200' => [
            'description' => 'A JSON object of {MODEL_NAME} model',
            'content' => [
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/{MODEL_NAME}',
                        'example' => [],
                    ],
                ],
            ],
        ],
        '404' => [
            'description' => '{MODEL_NAME} not found',
        ],
    ],
];