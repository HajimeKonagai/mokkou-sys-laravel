declare var route

export default {

    /*
    'アカウント': {
        'アカウント一覧': route('account.index'),
        'アカウント新規作成': route('account.create'),
        0: route('account.edit', {item: '*' }),
    },
     */

    '現場' : route('admin.project'),
    '見積り':  route('admin.estimate'),
    '発注' : route('admin.order'),

    '材料データ' :  route('admin.material'),
    '仕入先':  route('admin.user'),
    '顧客':  route('admin.customer'),
    '品目':  route('admin.product'),
}
