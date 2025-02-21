<?php

return [
    'order_id_prefix' => env('ORDER_ID_PROFIX', 'ORD-'),
    'order_id_pad' => env('ORDER_ID_PRD', 6),
    'order_status' => [
        0 => '未発注',
        1 => '発注済み',
        2 => '納品済み',
    ],
];