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
        // 仕入先
        'name' => [
            'label' => '仕入先名',
            'type' => 'text',
            'size' => 50,
            'search' => [
                'name' => [
                    'label' => '仕入先名',
                    'type' => 'text',
                    'compare' => 'like',
                    'placeholder' => 'あいまい検索',
                ],
            ],
            'required' => true,
        ],
        'address' => [
            'label' => '仕入先住所',
            'type' => 'textarea',
            'size' => 'full',
            'search' => [
                'address' => [
                    'label' => '仕入先住所',
                    'type' => 'text',
                    'compare' => 'like',
                    'placeholder' => 'あいまい検索',
                ],
            ],
        ],
        'staff' => [
            'label' => '仕入先担当者',
            'type' => 'text',
            'size' => 25,
            'search' => [
                'staff' => [
                    'label' => '仕入先担当者',
                    'type' => 'text',
                    'compare' => 'like',
                    'placeholder' => 'あいまい検索',
                ],
            ],
        ],

        'email' => [
            'label' => 'メールアドレス',
            'type' => 'email',
            'size' => 50,
            'search' => [
                'email' => [
                    'label' => 'メールアドレス',
                    'type' => 'text',
                    'compare' => 'like',
                    'placeholder' => 'あいまい検索',
                ],
            ],
            'required' => true,
        ],
        'password' => [
            'label' => 'パスワード',
            'type' => 'password',
            'size' => 50,
        ],
        'password_confirmation' => [
            'label' => 'パスワード(確認)',
            'type' => 'password',
            'size' => 50,
        ],

        'material_price' => [
            'label' => '絞り込み中材料単価',
            'type' => false,
        ],

        /*
        'material' => [
            'label' => '材料データ',
            'type' => 'belongsToMany',
            'search' => [
                'material_id' => [
                    'label' => '材料データ ID',
                    'type' => false,
                    'field' => 'material.id',
                ],
                'material_code' => [
                    'label' => '材料データ コード',
                    'type' => 'text',
                    'field' => 'material.code',
                ],
                'material_name' => [
                    'label' => '材料データ 材料データ名',
                    'type' => 'text',
                    'compare' => 'like',
                    'field' => 'material.name',
                    'placeholder' => 'あいまい検索',
                ],
            ],
            'belongsToMany' => [
                'label' => 'name',
            ],
            'IndexChoice' => [
                'preview' => 'name',
            ]
        ],
        */

        // 仕入先と金額設定
        'pricing' => [
            'label' => '材料データ＆金額設定',
            'type' => 'hasMany',
            'hasMany' => [
                'config' => [
                    'material' => [
                        'type' => 'belongsTo',
                        'attribute' => 'material_name',
                    ],
                    'price' => [
                        'type' => 'text',
                    ],
                ],
            ],
            'HasManyUnique' => [
                'unique' => 'material',
                'attribute' => [
                    'material_name' => 'name'
                ],
            ]
        ],

    ],
    'index' => [
        '_control',
        'id',
        'name',
        'address',
        'staff',
        'email',
        'material_price',
    ],
    'search' => [
        ['name', 'address', 'staff', 'email'],
        ['material_code', 'material_name']
    ],
    'form' => [
        ['name', 'staff'],
        'address',
        'email',
        'password',
        'password_confirmation',
        'pricing',
    ],
];