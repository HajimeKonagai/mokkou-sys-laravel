<?php

return [
    'config' => [
        'id' => [
            'label' => '発注番号',
            'type' => 'raw',
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
        // プロジェクト
        'project' => [
            'label' => 'プロジェクト',
            'type' => 'belongsTo',
            'search' => [
                'project_name' => [
                    'label' => 'プロジェクト名',
                    'field' => 'project.name',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
            'options' => [
                '' => ['id' => 0, 'name' => ''],
            ],
            'belongsTo' => [
                'label' => 'name',
            ],
            'IndexReference' => [
                'preview' => ['name'],
            ],
            'sort' => true,
            'attribute' => 'project_name',
        ],
        'status' => [
            'label' => 'ステータス',
            'type' => 'raw',
            'search' => [
                'status' => [
                    'label' => 'ステータス',
                    'type' => 'select',
                    'options' => [
                        '' => '',
                    ],
                ],
            ],
            'sort' => true,
            'attribute' => 'status_text',
            'description' => '一覧・編集の「発注処理」時に変更されます',
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
            'description' => '一覧・編集の「発注処理」時に入力されます',
        ],
        'deadline_at' => [
            'label' => '希望納期',
            'type' => 'date',
            'search' => [
                'deadline_at_from' => [
                    'label' => '希望納期(〜から)',
                    'type' => 'date',
                    'compare' => '>=',
                    'placeholder' => '',
                ],
                'deadline_at_to' => [
                    'label' => '希望納期(〜まで)',
                    'type' => 'date',
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
                    'seq' => [
                        'label' => '',
                        'type' => 'order',
                    ],
                    'product' => [
                        'label' => '材料データ',
                        'type' => 'belongsTo',
                        'IndexReference' => [
                            'preview' => ['name'],
                            'reference' => [
                                'code' => 'code',
                                'name' => 'name',
                                'unit' => 'unit',
                                'price' => 'price',
                            ],
                        ],
                        'attribute' => 'product_name',
                        'description' => '「仕入先」の選択によって自動的に絞り込まれます',
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
                        'size' => 30,
                    ],
                    // 単価
                    'price' => [
                        'label' => '単価',
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
                        'size' => 8,
                    ],

                    // 仕入先
                    'user' => [
                        'label' => '仕入れ先',
                        'type' => 'belongsTo',
                        'IndexReference' => [
                            'preview' => ['name'],
                        ],
                        'attribute' => 'user_name',
                        'description' => '「材料データ」の選択によって自動的に絞り込まれます',
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
        '_order_control',
        'deadline_at',
        'id',
        'project',
        'detail',
    ],
    'search' => [
        ['code', 'name', 'status'],
        ['ordered_at_from', 'ordered_at_to'],
        'detail',
    ],
    'form' => [
        ['id', 'status', 'ordered_at'],
        'name',
        'project',
        'deadline_at',
        'detail',
    ],
];