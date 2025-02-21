<?php

return [
    'user' => [
        [
            'name' => '鉄鋼商事',
            'email' => 'alex.functiontales@gmail.com',
        ],
        [
            'name' => '建材プロ',
            'email' => 'otegami@tsukitsume.com',
        ],
        [
            'name' => 'メタルテック',
            'email' => 'n.globe.us@gmail.com',
        ],
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

    'project' => [
        [ 'name' => '東京タワー改修工事' ],
        [ 'name' => 'スカイツリー補強工事' ],
    ],

    'order' => [
        [
            'project' => ['id' => 1],
            'status' => 1,
            'ordered_at' => '2023-06-01',
            'detail' => [
                [
                    'seq' => 1,
                    'product' => ['id' => 1],
                    'quantity' => 10,
                    'code' => 'AJK-001-030360',
                    'name' => 'アイキメタルTK 1.2x4x8',
                    'unit' => '枚',
                    'price' => '10000',
                    'user' => ['id' => 2],
                    'delivery_at' => '2024-01-15',
                ],
                [
                    'seq' => 2,
                    'product' => ['id' => 2],
                    'quantity' => 5,
                    'code' => 'AJK-001-030370',
                    'name' => 'アイキメタルTKJ 1.2x4x8',
                    'unit' => '枚',
                    'price' => '12000',
                    'user' => ['id' => 3],
                ],
            ],
        ],
        [
            'project' => ['id' => 2],
            'status' => 2,
            'ordered_at' => '2023-06-15',
            'detail' => [
                [
                    'seq' => 1,
                    'product' => ['id' => 3],
                    'quantity' => 20,
                    'code' => 'AJK-001-030380',
                    'name' => 'アイキメタルTNY 1.2x4x8',
                    'unit' => '枚',
                    'price' => '15000',
                    'user' => ['id' => 4],
                ],
            ],
        ],
    ]
];