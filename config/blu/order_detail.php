<?php

return [
    'config' => [
        // 材料コード
        'code' => [
            'label' => '材料コード',
            'type' => 'text',
        ],
        // 現場
        'project' => [
            'label' => '現場名',
            'type' => 'text',
            'size' => 30,
            'search' => [
                'name' => [
                    'label' => '材料名',
                    'field' => 'name',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
            'sort' => true,
            'attribute' => 'project_name',
        ],
        // 材料名
        'name' => [
            'label' => '材料名',
            'type' => 'text',
            'size' => 30,
            'search' => [
                'name' => [
                    'label' => '材料名',
                    'field' => 'name',
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
                    'label' => '単価〜から',
                    'field' => 'price',
                    'type' => 'number',
                    'compare' => '>=',
                ],
                'price_to' => [
                    'label' => '単価〜まで',
                    'field' => 'price',
                    'type' => 'number',
                    'compare' => '<=',
                ],
            ],
        ],
        // 数量
        'quantity' => [
            'label' => '数量',
            'type' => 'number',
            'size' => 10,
            'search' => [
                'price_from' => [
                    'label' => '数量〜から',
                    'field' => 'quantity',
                    'type' => 'number',
                    'compare' => '>=',
                ],
                'price_to' => [
                    'label' => '数量〜まで',
                    'field' => 'quantity',
                    'type' => 'number',
                    'compare' => '<=',
                ],
            ],
        ],
        // 単位
        'unit' => [
            'label' => '単位',
            'type' => 'text',
            'size' => 8,
            'search' => [
                'name' => [
                    'label' => '材料名',
                    'field' => 'name',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
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
            'sort' => true,
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