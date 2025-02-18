<?php

return [
    'summary' => 'Update a {MODEL_NAME}',
    'operationId' => '',
    'tags' => [],
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
        '200' => [
            'description' => '{MODEL_NAME} updated successfully',
            'content' => [
                'application/json' => [
                    'schema' => [
                        '$ref' => '#/components/schemas/{MODEL_NAME}',
                    ],
                ],
            ],
        ],
        '404' => [
            'description' => '{MODEL_NAME} not found',
        ],
    ],
];