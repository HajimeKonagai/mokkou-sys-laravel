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
            ]
        ],
        'name' => [
            'label' => '品目名',
            'type' => 'text',
            'size' => 50,
            'search' => [
                'name' => [
                    'label' => '品目名',
                    'type' => 'text',
                    'compare' => 'like',
                    'placeholder' => 'あいまい検索',
                ],
            ],
            'required' => true,
        ],
        // 単価
        'price' => [
            'label' => '単価',
            'type' => 'text',
            'after' => '×',
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
            'type' => 'number',
            'size' => 10,
        ],

        // 仕入先と金額設定
        'product_material' => [
            'label' => '材料データなど',
            'type' => 'hasMany',
            'hasMany' => [
                'config' => [
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
                            ],
                        ],
                        'attribute' => 'material_name',
                    ],
                    'name' => [
                        'label' => '名称',
                        'type' => 'text',
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
            'sort' => true,
            'HasManyUnique' => [
                'unique' => 'material',
                'attribute' => [
                    'material_name' => 'name',
                    'name' => 'name',
                    'price' => 'price',
                ],
            ],
        ], 
    ],
    'index' => [
        '_control',
        'id',
        'name',
        'total',
        'product_material',
    ],
    'search' => [
        [
            'name',
        ],
    ],
    'form' => [
        'name',
        ['price',
        'quantity',
        'unit',
        'total'],
        'product_material',
    ],
];