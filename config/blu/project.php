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
        'address' => [
            'label' => '住所',
            'type' => 'textarea',
            'size' => 'full',
            'search' => [
                'address' => [
                    'label' => '住所',
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
        'customer_id',
        'name',
        'address',
        'staff',
    ],
    'form' => [
        'customer_id',
        'name',
        'address',
        'staff',
    ],
];