<?php

return [
    'config' => [
        'id' => [
            'type' => false,
            'search' => [
                'id' => [
                    'label' => 'ID',
                    'type' => 'text',
                ],
            ],
            'sort' => true,
        ],
        // 材料コード
        'code' => [
            'label' => '材料コード',
            'type' => 'text',
            'search' => [
                'code' => [
                    'label' => '材料コード',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
            'sort' => true,
        ],
        // 商品名
        'name' => [
            'label' => '商品名',
            'type' => 'text',
            'search' => [
                'name' => [
                    'label' => '商品名',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
            'sort' => true,
        ],
        // 仕入先
        'user' => [
            'label' => '仕入先',
            'type' => 'belongsToMany',
            'search' => [
                'user_email' => [
                    'label' => '仕入先 メールアドレス',
                    'type' => 'text',
                    'field' => 'user.email',
                ],
                'user_name' => [
                    'label' => '仕入先 仕入先名',
                    'type' => 'text',
                    'compare' => 'like',
                    'field' => 'user.name',
                ],
            ],
            'sort' => true,
            'belongsToMany' => [
                'label' => 'name',
            ],
        ],

        // 単位
        'unit' => [
            'label' => '単位',
            'type' => 'text',
            'search' => [
                'unit' => [
                    'label' => '単位',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
            'sort' => true,
        ],
        // 単価
        'price' => [
            'label' => '単価',
            'type' => 'text',
            'search' => [
                'price_from' => [
                    'label' => '単価(〜から)',
                    'type' => 'number',
                    'compare' => '>=',
                ],
                'price_to' => [
                    'label' => '単価(〜まで)',
                    'type' => 'number',
                    'compare' => '<=',
                ],
            ],
            'sort' => true,
        ],
        'created_at' => [
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
        // 'id',
        'code',
        'name',
        // 'user',
        'unit',
        'price',
        // 'created_at',
        // 'updated_at',
    ],
    'search' => [
        // 'id',
        ['code', 'name', 'unit'],
        ['price_from', 'price_to'],
        ['user_name', 'user_email'],
    ],
    'form' => [
        'id',
        'code',
        'name',
        'unit',
        'price',
        'user',
        // 'created_at',
        // 'updated_at',
    ],
];