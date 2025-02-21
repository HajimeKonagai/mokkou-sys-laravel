<?php

return [
    'config' => [
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

        'order_code' => [
            'label' => '発注番号',
            'type' => 'raw',
            'attribute' => 'order_code',
            'sort' => 'order.id',
        ],
        'order_deadline_at' => [
            'label' => '希望納期',
            'type' => 'raw',
            'attribute' => 'order_deadline_at',
            'sort' => 'order.deadline_at',
        ],

        // 納期
        'delivery_at' => [
            'label' => '納期',
            'type' => 'raw',
        ],
    ],
    'index' => [
        '_control',
        'order_code',
        'order_deadline_at',
        'code',
        'name',
        'price',
        'quantity',
        'unit',
    ],
    'search' => [
        ['code', 'name', 'status'],
        ['ordered_at_from', 'ordered_at_to'],
        'detail',
    ],
    'form' => [
        'code',
        'name',
        'price',
        'quantity',
        'unit',
    ],
];