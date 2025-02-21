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
}
