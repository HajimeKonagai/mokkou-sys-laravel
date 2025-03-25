declare var route

export default {

    /*
    'アカウント': {
        'アカウント一覧': route('account.index'),
        'アカウント新規作成': route('account.create'),
        0: route('account.edit', {item: '*' }),
    },
     */

    '現場' : route('admin.project.index'),
    '発注' : route('admin.order.index'),
    '材料データ' :  route('admin.product.index'),
    '仕入先':  route('admin.user.index'),
}
