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
            'label' => '現場名',
            'type' => 'text',
            'size' => 50,
            'search' => [
                'name' => [
                    'label' => '現場名',
                    'type' => 'text',
                    'compare' => 'like',
                    'placeholder' => 'あいまい検索',
                ],
            ],
            'required' => true,
        ],
        'customer_id' => [
            'label' => '顧客',
            'type' => 'select',
            'options' => [
                '' => '',
            ],
            'size' => 50,
            'search' => [
                'customer_id' => [
                    'label' => '顧客',
                    'type' => 'select',
                    'options' => [ '' => '' ],
                ],
            ],
        ],
        'address' => [
            'label' => '現場住所',
            'type' => 'textarea',
            'size' => 'full',
            'search' => [
                'address' => [
                    'label' => '現場住所',
                    'type' => 'text',
                    'compare' => 'like',
                    'placeholder' => 'あいまい検索',
                ],
            ],
        ],
        'staff' => [
            'label' => '担当者',
            'type' => 'text',
            'size' => 50,
            'search' => [
                'staff' => [
                    'label' => '担当者',
                    'type' => 'text',
                    'compare' => 'like',
                    'placeholder' => 'あいまい検索',
                ],
            ],
        ],
        'total_price' => [
            'type' => false,
            'label' => '合計金額',
            'attribute' => 'total_price'
        ],
        'order' => [
            'type' => false,
            'label' => '発注',
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

    ],
    'index' => [
        '_control',
        'id',
        'customer_id',
        'name',
        'address',
        'staff',
    ],
    'search' => [
        [
            'customer_id',
            'name',
            'address',
            'staff',
        ],
    ],
    'form' => [
        [
            'customer_id', 'name',
            'staff',
        ],
        'address',
        [
            'deadline',
            'condition',
            'location',
            'expiration',
        ],
        'total_price',
    ],
];