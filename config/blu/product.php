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

       // 材料
       'material_cost' => [
            'label' => '材料-費用',
            'type' => 'text',
        ],
        // 加工
        'process_cost' => [
            'label' => '加工-費用',
            'type' => 'number',
        ],
        // 副資材
        'aux_cost' => [
            'label' => '副資材-費用',
            'type' => 'text',
            'description' => '([材料-費用] + [加工-費用]) × 5%'
        ],
        // 取付
        'attach_cost' => [
            'label' => '取付-費用',
            'type' => 'number',
        ],
        'cost_total' => [
            'label' => '費用-合計',
            'type' => 'text',
            'description' => '[材料-費用] + [加工-費用] + [副資材-費用] + [取付-費用]'
        ],
        'rate' => [
            'label' => '掛率',
            'type' => 'number',
            'default' => env('RATE_DEFAULT', 0.6),
        ],
        'raw_price' => [
            'label' => '売値',
            'type' => 'text',
            'description' => '[費用-合計] ÷ [掛率]',
        ],
        'net_rate' => [
            'label' => 'ネット掛率',
            'type' => 'text',
            'default' => env('NET_RATE_DEFAULT', 0.65),
            'description' => "品目登録時はデフォルト値(".env('NET_RATE_DEFAULT', 0.65).")で計算していますが、\n見積り時は現場で設定されている値を参照します。"
        ],
        'price' => [
            'label' => 'ネット金額',
            'type' => 'number',
            'description' => '[売値] ÷ [ネット掛率] に2桁切り上げ',
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
            'description' => '[ネット金額] × [数量]'
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
                    'seq' => [
                        'label' => '順序',
                        'type' => 'seq',
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
        [
            'material_cost',
            'process_cost',
            'aux_cost',
            'attach_cost',
            'cost_total',
        ],
        [
            'rate',
            'raw_price',
            'net_rate',
        ],
        ['price', 'quantity', 'unit'],
        'total',
        'product_material',
    ],
];