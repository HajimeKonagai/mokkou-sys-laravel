<?php

return [
    'config' => [
        'id' => [
            'label' => 'ID',
            'type' => 'raw',
            'search' => [
                'id' => [
                    'label' => 'ID',
                    'type' => 'text',
                ],
            ],
            'sort' => true,
            'attribute' => 'code',
        ],
        'seq' => [
            'label' => 'No.',
            'type' => 'seq',
        ],
        'name' => [
            'label' => '名称',
            'type' => 'text',
            'size' => 50,
        ],

        // 材料
        'material_cost' => [
            'label' => '材料-費用',
            'type' => 'number',
            'default' => 0,
        ],
        // 加工
        'process_cost' => [
            'label' => '加工-費用',
            'type' => 'number',
            'default' => 0,
        ],
        // 取付
        'attach_cost' => [
            'label' => '取付-費用',
            'type' => 'number',
            'default' => 0,
        ],
        'cost_total' => [
            'label' => '費用-合計',
            'type' => 'number',
            'default' => 0,
        ],
        'rate' => [
            'label' => '掛率',
            'type' => 'number',
            'default' => 1.0,
        ],
        'raw_price' => [
            'label' => '売値',
            'type' => 'number',
        ],
        'price' => [
            'label' => 'ネット金額',
            'type' => 'number',
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

        'total' => [
            'label' => '合計',
            'type' => 'number',
            'size' => 10,
        ],


        'task_material' => [
            'label' => '材料',
            'type' => 'hasMany',
            'hasMany' => [
                'config' => [
                    'seq' => [
                        'label' => '',
                        'type' => 'seq',
                    ],
                    'material' => [
                        'label' => '材料データ',
                        'type' => 'belongsTo',
                        'IndexReference' => [
                            'preview' => ['name'],
                            'reference' => [
                                'code' => 'code',
                                'name' => 'name',
                                'unit' => 'unit',
                                'price' => 'price',
                                'quantity' => 'quantity',
                                'total' => 'total',
                            ],
                        ],
                        'attribute' => 'material_name',
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
                        'type' => 'number',
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
                    'total' => [
                        'label' => '合計',
                        'type' => 'number',
                        'size' => 10,
                    ],
                ],
            ],
        ],

        'product' => [
            'label' => '品目の参照',
            'type' => 'belongsTo',
            'IndexReference' => [
                'preview' => ['name'],
                'reference' => [
                    'name' => 'name',
                    'price' => 'price',
                    'unit' => 'unit',
                    'quantity' => 'quantity',
                    'total' => 'total',
                    'product_material' => [
                        'field' => 'task_material',
                        'reference' => [
                            'seq' => 'seq',
                            'material' => 'material',
                            'material.code' => 'code',
                            'name' => 'name',
                            'price' => 'price',
                            'unit' => 'unit',
                            'quantity' => 'quantity',
                            'total' => 'total',
                        ],
                    ],
                ],
            ],
            'attribute' => 'product_name',
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
        'seq',
        'name',
        'price',
        'quantity',
        'unit',
        'total',
    ],
    'search' => [
        ['code', 'name', 'status'],
        ['ordered_at_from', 'ordered_at_to'],
        'detail',
    ],
    'form' => [
        ['seq', 'status', 'ordered_at'],
        'name',
        [
            'material_cost',
            'process_cost',
            'attach_cost',
            'cost_total',
        ],
        [
            'rate',
            'raw_price',
            'price',
        ],
        ['quantity', 'unit'],
        'total',

        'product',

        'task_material',
    ],
];