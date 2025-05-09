declare var route

export default {

    /*
    'アカウント': {
        'アカウント一覧': route('account.index'),
        'アカウント新規作成': route('account.create'),
        0: route('account.edit', {item: '*' }),
    },
     */



    'csv':  {
        'csv - 顧客': route('admin.csv.customer')
    },
}

const master_menu = {
    'マスタデータ' : {
        '顧客':  route('admin.customer'),
        '見積り品目':  route('admin.product'),
        '材料データ' :  route('admin.material'),
        '仕入先':  route('admin.user'),
    }
}

const project_menu = {
    'プロジェクト': {
        '現場一覧' : route('admin.project'),
        '見積り':  route('admin.task'),
        '発注' : route('admin.order'),
    }
}

const csv_menu = {
    'csv':  {
        'csv - 顧客': route('admin.csv.customer')
    },
}

export {
    master_menu,
    project_menu,
    csv_menu,
}
