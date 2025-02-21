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
            'label' => 'プロジェクト名',
            'type' => 'text',
            'size' => 50,
            'search' => [
                'name' => [
                    'label' => 'プロジェクト名',
                    'type' => 'text',
                    'compare' => 'like',
                    'placeholder' => 'あいまい検索',
                ],
            ],
            'required' => true,
        ],
        'dev' => [
            'type' => 'raw',
            'description' => '必要な入力項目は作りますので洗い出してください',
        ]
    ],
    'index' => [
        '_control',
        'id',
        'name',
    ],
    'search' => [
        'name',
    ],
    'form' => [
        'name',
        'dev',
    ],
];