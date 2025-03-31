<?php

return [
    'config' => [
        'id' => [
            'label' => '見積り番号',
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
        'name' => [
            'label' => 'タイトル',
            'type' => 'text',
            'sort' => true,
            'size' => 50,
        ],

        'estimated_at' => [
            'label' => '見積り日',
            'type' => 'date',
            'sort' => true,
            'size' => 50,
        ],
        'deadline' => [
            'label' => '納期',
            'type' => 'text',
            'sort' => true,
            'size' => 50,
        ],
        'condition' => [
            'label' => '取引条件',
            'type' => 'text',
            'sort' => true,
            'size' => 50,
        ],
        'location' => [
            'label' => '受渡場所',
            'type' => 'text',
            'sort' => true,
            'size' => 50,
        ],
        'expiration' => [
            'label' => '見積り有効期限',
            'type' => 'text',
            'sort' => true,
            'size' => 50,
        ],
        'total' => [
            'label' => '見積り合計',
            'type' => 'text',
            'sort' => true,
            'size' => 50,
        ],


        'estimate_product' => [
            'label' => '品目',
            'type' => 'hasMany',
            'hasMany' => [
                'tag' => 'ul',
                'config' => [
                    'seq' => [
                        'label' => 'No.',
                        'type' => 'seq',
                    ],

                    'name' => [
                        'label' => '品目名',
                        'type' => 'text',
                        'size' => 30,
                    ],
                    // 単価
                    'price' => [
                        'label' => '単価',
                        'type' => 'text',

                        '_calcMaterials'=> true,
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
                        'type' => 'text',
                        'size' => 10,
                    ],


                    'product_material' => [
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
                                'total' => [
                                    'label' => '合計',
                                    'type' => 'text',
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
                                    'field' => 'product_material',
                                    'reference' => [
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
        'name',
        'total',
        // 'id',
        ['deadline', 'condition', 'location', 'expiration'],
        'estimate_product',
        // 'detail',
    ],
    'search' => [
        ['code', 'name', 'status'],
        ['ordered_at_from', 'ordered_at_to'],
        'detail',
    ],
    'form' => [
        ['id', 'status', 'ordered_at'],
        [ 'name', 'estimated_at'],
        ['deadline', 'condition', 'location', 'expiration'],
        'total',

        'estimate_product',
    ],
];