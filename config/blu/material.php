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
            'size' => 30,
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
            'size' => 50,
            'search' => [
                'name' => [
                    'label' => '商品名',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
            'sort' => true,
        ],
        /*
        // 仕入先
        'user' => [
            'label' => '仕入先',
            'type' => 'belongsToMany',
            'search' => [
                'user_id' => [
                    'label' => '仕入先 ID',
                    'type' => false,
                    'field' => 'user.id',
                ],
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
            'IndexChoice' => [
                'preview' => 'name',
            ]
        ],
        */

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
            'label' => '見積り単価',
            'type' => 'text',
            'after' => '円',
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
        // 仕入先と金額設定
        'pricing' => [
            'label' => '仕入先＆金額設定',
            'type' => 'hasMany',
            'hasMany' => [
                'config' => [
                    'user' => [
                        'label' => '仕入先',
                        'type' => 'belongsTo',
                        'attribute' => 'user_name',
                    ],
                    'price' => [
                        'label' => '単価',
                        'type' => 'text',
                    ],
                ],
            ],
            'search' => [
                'user_id' => [
                    'label' => '仕入先 ID',
                    'type' => false,
                    'field' => 'user.id',
                ],
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
            'HasManyUnique' => [
                'unique' => 'user',
                'attribute' => [
                    'user_name' => 'name'
                ],
            ],
        ],

        'user_price' => [
            'label' => '絞り込みユーザー単価',
            'type' => false,
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
        'price',
        'pricing',
        'unit',
        'user_price',
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
        'code',
        'name',
        ['unit', 'price'],
        'pricing',
    ],
];