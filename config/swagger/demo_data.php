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


    'material' => [
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

    'customer' => [
        ['name' => '顧客A', 'address' => '顧客A住所'],
        ['name' => '顧客B', 'address' => '顧客B住所'],
    ],
    'project' => [
        [
            'name' => '東京タワー改修工事',
            'customer_id' => 1,
            'address' => '東京タワー改修工事住所',
            'staff' => '東京タワー担当者',
        ],
        [
            'name' => 'スカイツリー補強工事',
            'customer_id' => 2,
            'address' => 'スカイツリー補強工事住所',
            'staff' => 'スカイツリー担当者',
        ],
    ],

    'order' => [
        [
            'project' => ['id' => 1],
            'status' => 1,
            'ordered_at' => '2023-06-01',
            'detail' => [
                [
                    'seq' => 1,
                    'material' => ['id' => 1],
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
                    'material' => ['id' => 2],
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
                    'material' => ['id' => 3],
                    'quantity' => 20,
                    'code' => 'AJK-001-030380',
                    'name' => 'アイキメタルTNY 1.2x4x8',
                    'unit' => '枚',
                    'price' => '15000',
                    'user' => ['id' => 4],
                ],
            ],
        ],
    ],


    'product' => [
        [
            'name' => '巾木',
            'product_material' => [
                [
                    'seq' => 1,
                    'material' =>     [
                        'id' => 1,
                        'code' => 'AJK-001-030360',
                        'name' => 'アイキメタルTK 1.2x4x8',
                        'unit' => '枚',
                        'price' => '10000',
                    ],
                    'code' => 'AJK-001-030360',
                    'name' => 'アイキメタルTK 1.2x4x8',
                    'quantity' => 1,
                    'unit' => '枚',
                    'price' => '10000',

                ],
                [
                    'seq' => 2,
                    'material' =>     [
                        'id' => 2,
                        'code' => 'AJK-001-030370',
                        'name' => 'アイキメタルTKJ 1.2x4x8',
                        'unit' => '枚',
                        'price' => '12000',
                    ],
                    'code' => 'AJK-001-030370',
                    'name' => 'アイキメタルTKJ 1.2x4x8',
                    'quantity' => 2,
                    'unit' => '枚',
                    'price' => '12000',
                ],
                [
                    'seq' => 3,
                    'material' =>     [
                        'id' => 3,
                        'code' => 'AJK-001-030380',
                        'name' => 'アイキメタルTNY 1.2x4x8',
                        'unit' => '枚',
                        'price' => '15000',
                    ],
                    'code' => 'AJK-001-030380',
                    'name' => 'アイキメタルTNY 1.2x4x8',
                    'quantity' => 3,
                    'unit' => '枚',
                    'price' => '15000',
                ],
                [
                    'seq' => 4,
                    'material' => null,
                    'name' => '工賃',
                    'price' => '12000',
                    'quantity' => 1,
                ],
            ]
        ]
    ],
    'estimate' => [
        
    ]
];