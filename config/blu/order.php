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
        // 発注番号
        'code' => [
            'label' => '発注番号',
            'type' => 'text',
            'search' => [
                'code' => [
                    'label' => '発注番号',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
            'sort' => true,
            'required' => true,
        ],
        // プロジェクト
        'name' => [
            'label' => 'プロジェクト',
            'type' => 'text',
            'size' => 50,
            'search' => [
                'name' => [
                    'label' => 'プロジェクト',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
            'sort' => true,
        ],
        'status' => [
            'label' => 'ステータス',
            'type' => 'raw',
            'options' => [
                0 => '未発注',
                1 => '発注済み',
                2 => '納品済み',
            ],
            'search' => [
                'status' => [
                    'label' => 'ステータス',
                    'type' => 'select',
                    'options' => [
                        0 => '未発注',
                        1 => '発注済み',
                        2 => '納品済み',
                    ],
                ],
            ],
            'sort' => true,
        ],
        'ordered_at' => [
            'label' => '発注日',
            'type' => 'raw',
            'search' => [
                'ordered_at' => [
                    'label' => '発注日',
                    'type' => 'datetime-local',
                    'compare' => '=',
                    'placeholder' => '',
                ],
                'ordered_at_from' => [
                    'label' => '発注日(〜から)',
                    'type' => 'datetime-local',
                    'compare' => '>=',
                    'placeholder' => '',
                ],
                'ordered_at_to' => [
                    'label' => '発注日(〜まで)',
                    'type' => 'datetime-local',
                    'compare' => '<=',
                    'placeholder' => '',
                ],
            ],
            'sort' => true,
        ],
        'detail' => [
            'label' => '発注アイテム',
            'type' => 'hasMany',
            'hasMany' => [
                'config' => [
                    'product' => [
                        'label' => '商品',
                        'type' => 'belongsTo',
                        'belongsTo' => [
                            'label' => 'name',
                            'type' => 'select',
                            'reference' => [
                                'code' => 'code',
                                'name' => 'name',
                                'unit' => 'unit',
                                'price' => 'price',
                            ]
                        ],
                        'options' => [
                            '0' => ['id' => 0, 'name' => ''],
                        ],
                    ],
                    // 材料コード
                    'code' => [
                        'label' => '材料コード',
                        'type' => 'text',
                    ],
                    // 材料名
                    'name' => [
                        'label' => '材料名',
                        'type' => 'text',
                    ],
                    // 数量
                    'quantity' => [
                        'label' => '数量',
                        'type' => 'number',
                        'size' => 10,
                    ],
                    // 単位
                    'unit' => [
                        'label' => '単位',
                        'type' => 'text',
                        'size' => 10,
                    ],
                    // 単価
                    'price' => [
                        'label' => '単価',
                        'type' => 'text',
                        'size' => 20,
                    ],
                    // 仕入先
                    'user' => [
                        'label' => '仕入れ先',
                        'type' => 'belongsTo',
                        'belongsTo' => [
                            'label' => 'name',
                            'type' => 'select',
                        ],
                        'options' => [
                            '' => ['id' => 0, 'name' => ''],
                        ],
                    ],
                    // 納期
                    'deadline' => [
                        'label' => '納期',
                        'type' => 'raw',
                    ],
                ]
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
        'code',
        'name',
        'status',
        'ordered_at',
        'detail',
    ],
    'search' => [
        ['code', 'name', 'status'],
        ['ordered_at_from', 'ordered_at_to'],
        'detail',
    ],
    'form' => [
        'code',
        'name',
        ['status', 'ordered_at'],
        'detail',
    ],
];