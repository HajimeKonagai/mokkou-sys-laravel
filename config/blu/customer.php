<?php

return [
    'config' => [
        'id' => [
            'label' => 'ID',
            'type' => false,
            'search' => [
                'id' => [
                    'label' => 'ID',
                    'type' => 'text',
                ],
            ],
            'sort' => true,
            'attribute' => 'code',
            'description' => '保存時に自動採番されます。'
        ],
        'name' => [
            'label' => '顧客名',
            'type' => 'text',
            'size' => 50,
            'search' => [
                'name' => [
                    'label' => '顧客名',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
        ],
        'zip' => [
            'label' => '郵便番号',
            'type' => 'text',
            'size' => 12,
            'search' => [
                'zip' => [
                    'label' => '郵便番号',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
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
                ],
            ],
        ],
        'tel' => [
            'label' => 'TEL',
            'type' => 'text',
            'size' => 50,
            'search' => [
                'tel' => [
                    'label' => 'TEL',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
        ],
        'fax' => [
            'label' => 'FAX',
            'type' => 'text',
            'size' => 50,
            'search' => [
                'fax' => [
                    'label' => 'FAX',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
        ],
        'url' => [
            'label' => 'HP',
            'type' => 'text',
            'size' => 50,
            'search' => [
                'url' => [
                    'label' => 'HP',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
        ],

        'close_date' => [
            'label' => '締め日',
            'type' => 'text',
            'size' => 50,
            'search' => [
                'close_date' => [
                    'label' => '締め日',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
        ],
        'pay_date' => [
            'label' => '支払日',
            'type' => 'text',
            'size' => 50,
            'search' => [
                'pay_date' => [
                    'label' => '支払日',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
        ],
        'pay_way' => [
            'label' => '回収方法',
            'type' => 'text',
            'size' => 50,
            'search' => [
                'pay_way' => [
                    'label' => '回収方法',
                    'type' => 'text',
                    'compare' => 'like',
                ],
            ],
        ],


        'created_at' => [
            'label' => '',
            'type' => false,
            'search' => [
                'created_at_from' => [
                    'label' => '作成日時(〜から)',
                    'type' => 'datetime-local',
                    'compare' => '>=',
                    'placeholder' => '',
                ],
                'crearted_at_to' => [
                    'label' => '作成日時(〜まで)',
                    'type' => 'datetime-local',
                    'compare' => '<=',
                    'placeholder' => '',
                ],
            ],
            'sort' => true,
        ],
        'updated_at' => [
            'label' => '',
            'type' => false,
            'search' => [
                'updated_at_from' => [
                    'label' => '更新日時(〜から)',
                    'type' => 'datetime-local',
                    'compare' => '>=',
                    'placeholder' => '',
                ],
                'updated_at_to' => [
                    'label' => '更新日時(〜まで)',
                    'type' => 'datetime-local',
                    'compare' => '<=',
                    'placeholder' => '',
                ],
            ],
            'sort' => true,
        ],
    ],
    'index' => [
        '_control',
        'name',
        'address',
    ],
    'search' => [
        ['name', 'address'],
    ],
    'form' => [
        'name',
        'zip',
        'address',
        'tel',
        'fax', 
        'url',
        'close_date',
        'pay_date',
        'pay_way',
    ],
];