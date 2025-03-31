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
        ],
        'order' => [
            'type' => false,
            'label' => '発注',
        ]
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
        'customer_id',
        'name',
        'address',
        'staff',
        'total_price',
        'order',
    ],
];