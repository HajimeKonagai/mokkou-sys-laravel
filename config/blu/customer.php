<?php

return [
    'config' => [
        'id' => [
            'label' => 'ID',
            'type' => false,
            'search' => [
                'id' => [
                    'label' => 'ID',
                    'type' => 'text',
                ],
            ],
            'sort' => true,
            'attribute' => 'code',
            'description' => '保存時に自動採番されます。'
        ],
        'name' => [
            'label' => '顧客名',
            'type' => 'text',
            'size' => 50,
            'search' => [
                'name' => [
                    'label' => '顧客名',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
        ],
        'address' => [
            'label' => '住所',
            'type' => 'textarea',
            'size' => 'full',
            'search' => [
                'address' => [
                    'label' => '住所',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
        ],

        'created_at' => [
            'label' => '',
            'type' => false,
            'search' => [
                'created_at_from' => [
                    'label' => '作成日時(〜から)',
                    'type' => 'datetime-local',
                    'compare' => '>=',
                    'placeholder' => '',
                ],
                'crearted_at_to' => [
                    'label' => '作成日時(〜まで)',
                    'type' => 'datetime-local',
                    'compare' => '<=',
                    'placeholder' => '',
                ],
            ],
            'sort' => true,
        ],
        'updated_at' => [
            'label' => '',
            'type' => false,
            'search' => [
                'updated_at_from' => [
                    'label' => '更新日時(〜から)',
                    'type' => 'datetime-local',
                    'compare' => '>=',
                    'placeholder' => '',
                ],
                'updated_at_to' => [
                    'label' => '更新日時(〜まで)',
                    'type' => 'datetime-local',
                    'compare' => '<=',
                    'placeholder' => '',
                ],
            ],
            'sort' => true,
        ],
    ],
    'index' => [
        '_control',
        'name',
        'address',
    ],
    'search' => [
        ['name', 'address'],
    ],
    'form' => [
        'name',
        'address',
    ],
];