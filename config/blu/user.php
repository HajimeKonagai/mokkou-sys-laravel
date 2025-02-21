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

        'product' => [
            'label' => '材料データ',
            'type' => 'belongsToMany',
            'search' => [
                'product_id' => [
                    'label' => '材料データ ID',
                    'type' => false,
                    'field' => 'product.id',
                ],
                'product_code' => [
                    'label' => '材料データ コード',
                    'type' => 'text',
                    'field' => 'product.code',
                ],
                'product_name' => [
                    'label' => '材料データ 材料データ名',
                    'type' => 'text',
                    'compare' => 'like',
                    'field' => 'product.name',
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
    ],
    'index' => [
        '_control',
        'id',
        'name',
        'email',
    ],
    'search' => [
        ['name', 'email'],
        ['product_code', 'product_name']
    ],
    'form' => [
        'name',
        'email',
        'password',
        'password_confirmation',
        'product',
    ],
];