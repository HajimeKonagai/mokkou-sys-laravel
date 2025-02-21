declare var route

export default {

    /*
    'アカウント': {
        'アカウント一覧': route('account.index'),
        'アカウント新規作成': route('account.create'),
        0: route('account.edit', {item: '*' }),
    },
     */

    'プロジェクト' : {
        'プロジェクト一覧': route('admin.project.index'),
        'プロジェクト新規作成': route('admin.project.create'),
        0: route('admin.project.edit', {id: '*'}),
    },

    '発注' : {
        '発注一覧': route('admin.order.index'),
        '発注新規作成': route('admin.order.create'),
        0: route('admin.order.edit', {id: '*'}),
    },

    '材料データ' : {
        '材料データ一覧': route('admin.product.index'),
        '材料データ新規作成': route('admin.product.create'),
        0: route('admin.product.edit', {id: '*'}),
    },

    '仕入先' : {
        '仕入先一覧': route('admin.user.index'),
        '仕入先新規作成': route('admin.user.create'),
        0: route('admin.user.edit', {id: '*'}),
    },
}
