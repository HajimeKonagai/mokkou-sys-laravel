declare var route

export default {

    /*
    'アカウント': {
        'アカウント一覧': route('account.index'),
        'アカウント新規作成': route('account.create'),
        0: route('account.edit', {item: '*' }),
    },
     */


    '発注' : {
        '発注一覧': route('admin.order.index'),
        '新規発注作成': route('admin.order.create'),
        0: route('admin.order.edit', {id: '*'}),
    },

    '材料データ' : {
        '材料データ一覧': route('admin.product.index'),
        '新規材料データ作成': route('admin.product.create'),
        0: route('admin.product.edit', {id: '*'}),
    },

    '仕入れ先' : {
        '仕入れ先一覧': route('admin.user.index'),
        '新規仕入れ先作成': route('admin.user.create'),
        0: route('admin.user.edit', {id: '*'}),
    },
}
