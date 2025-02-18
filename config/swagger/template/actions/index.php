<?php

return [
    'tags' => [],
    'summary' => 'Get array of {MODEL_NAME} with pagination',
    'operationId' => '',
    'parameters' => [],
    'responses' => [
        '200' => [
            'description' => 'A JSON object of paginated {MODEL_NAME}',
            'content' => [
                'application/json' => [
                    'schema' => [ 
                        'type' => 'object',
                        'properties' => [
                            'data' => [
                                'type' => 'array',
                                'items' => [
                                    '$ref' => '#/components/schemas/{MODEL_NAME}' # 参照するモデル
                                ],
                            ],
                            'current_page' => [ 'type' => 'integer'],
                            'from' => ['type' => 'integer' ],
                            'to' => [ 'type' => 'integer' ],
                            'last_page' => [ 'type' => 'integer' ],
                            'per_page'  => [ 'type' => 'integer' ],
                            'total'  => [ 'type' => 'integer' ],
                            'path' => [ 'type' => 'string' ],
                            'prev_page_url' => [ 'type' => 'string', 'nullable' => true],
                            'next_page_url' => [ 'type' => 'string', 'nullable' => true],
                            'first_page_url' => ['type' => 'string' ],
                            'last_page_url' => ['type' => 'string' ],
                            'links' => [
                                'type' => 'array',
                                'items' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'url' => [ 'type' => 'string', 'nullable' => true],
                                        'label' => ['type' => 'string' ],
                                        'active' => [ 'type' => 'boolean' ],
                                    ],
                                ],
                            ],
                        ],
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