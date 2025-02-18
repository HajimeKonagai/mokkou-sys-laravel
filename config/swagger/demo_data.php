<?php

return [
    'user' => [
        [ 'name' => '鉄鋼商事' ],
        [ 'name' => '建材プロ' ],
        [ 'name' => 'メタルテック' ],
    ],

    'product' => [
        [
            'code' => 'AJK-001-030360',
            'name' => 'アイキメタルTK 1.2x4x8',
            'unit' => '枚',
            'price' => '10000',
            'user' => [
                [ 'id' => 2 ],
            ],
        ],
        [
            'code' => 'AJK-001-030370',
            'name' => 'アイキメタルTKJ 1.2x4x8',
            'unit' => '枚',
            'price' => '12000',
            'user' => [
                [ 'id' => 3 ],
            ],
        ],
        [
            'code' => 'AJK-001-030380',
            'name' => 'アイキメタルTNY 1.2x4x8',
            'unit' => '枚',
            'price' => '15000',
            'user' => [
                [ 'id' => 4 ],
            ],
        ],
    ],

    'order' => [
        [
            'code' => 'ORD-001',
            'name' => '東京タワー改修工事',
            'status' => 1,
            'ordered_at' => '2023-06-01',
            'detail' => [
                [
                    'product_id' => 1,
                    'quantity' => 10,
                    'code' => 'AJK-001-030360',
                    'name' => 'アイキメタルTK 1.2x4x8',
                    'unit' => '枚',
                    'price' => '10000',
                    'user_id' => 1,
                    'deadline' => '2024-01-15',
                ],
                [
                    'product_id' => 2,
                    'quantity' => 5,
                    'code' => 'AJK-001-030370',
                    'name' => 'アイキメタルTKJ 1.2x4x8',
                    'unit' => '枚',
                    'price' => '12000',
                    'user_id' => 2,
                    'deadline' => '2024-02-20',
                ],
            ],
        ],
        [
            'code' => 'ORD-002',
            'name' => 'スカイツリー補強工事',
            'status' => 2,
            'ordered_at' => '2023-06-15',
            'detail' => [
                [
                    'product_id' => 3,
                    'quantity' => 20,
                    'code' => 'AJK-001-030380',
                    'name' => 'アイキメタルTNY 1.2x4x8',
                    'unit' => '枚',
                    'price' => '15000',
                    'user_id' => 3,
                    'deadline' => '2024-03-10',
                ],
            ],
        ],
    ]
];