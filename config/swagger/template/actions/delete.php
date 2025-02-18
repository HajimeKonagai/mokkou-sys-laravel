<?php

return [
    'summary' => ' Delete a {MODEL_NAME}',
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
    'responses' => [
        '204' => [
            'description' => '{MODEL_NAME} deleted successfully',
        ],
        '404' => [
            'description' => '{MODEL_NAME} not found',
        ],
    ],
];