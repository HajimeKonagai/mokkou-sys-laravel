declare var route

export default {

    /*
    'アカウント': {
        'アカウント一覧': route('account.index'),
        'アカウント新規作成': route('account.create'),
        0: route('account.edit', {item: '*' }),
    },
     */

    '見積り':  route('admin.estimate'),
    '見積り品目':  route('admin.product'),
    '発注' : route('admin.order'),

    '顧客':  route('admin.customer'),
    '現場' : route('admin.project'),
    '材料データ' :  route('admin.material'),
    '仕入先':  route('admin.user'),
    'csv':  {
        'csv- 現場': route('admin.user')
    },
}
