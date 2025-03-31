
type ConstantsProp = {
    title: string
    route_prefix: string
    api_route_prefix:string
    soft_delete?: boolean,
}

const constants = ({
    title,
    route_prefix,
    api_route_prefix,
    soft_delete = false,
}: ConstantsProp) =>
{

    return {
        TITLE : title,
        route_prefix : route_prefix,
        api_route_prefix : 'admin.material',
        SOFT_DELETE : false,

        INDEX_PREFERENCE_KEY : `blu.${route_prefix}.index`,
        SEARCH_PREFERENCE_KEY : `blu.${route_prefix}.search`,
        FORM_PREFERENCE_KEY : `blu.${route_prefix}.form`,

        API_ROUTE    : `${api_route_prefix}`,
        STORE_ROUTE   : `${route_prefix}.store`,
        UPDATE_ROUTE   : `${route_prefix}.update`,
        SHOW_ROUTE   : `${route_prefix}.show`,
        EDIT_ROUTE   : `${route_prefix}.edit`,
        DELETE_ROUTE : soft_delete ? `${route_prefix}.dispose`: `${route_prefix}.destroy`,
        TRASH_ROUTE    : `${api_route_prefix}.trash`,
        RESTORE_ROUTE   : `${route_prefix}.restore`,
        ELIMINATE_ROUTE :  `${route_prefix}.eliminate`,

        DELETE_MESSAGE : soft_delete ? 'をゴミ箱に移動しますか？': 'を削除してもよろしいですか？\n(※この操作は取り消せません)',
        ELIMINATE_MESSAGE : 'を完全に削除してもよろしいですか？\n(※この操作は取り消せません)',

        CLASS_NAME : `${route_prefix.replace('.', '-')}`,

        TITLE_INDEX : `一覧`,
        TITLE_TRASH : `ゴミ箱`,
        TITLE_SHOW : `表示`,
        TITLE_CREATE : `新規作成`,
        TITLE_EDIT : `編集`,

        CONTROL_NAME : `操作`,
        CONTROL_SHOW_LABEL : `表示`,
        CONTROL_EDIT_LABEL : `編集`,
        CONTROL_DELETE_LABEL : `削除`,
        CONTROL_RESTORE_LABEL : `復活`,
        CONTROL_ELIMINATE_LABEL : `完全削除`,

        LABEL_STORE : `保存`,
        LABEL_UPDATE : `更新`,
    }
}


const projectConstants = constants({
    title: '現場',
    route_prefix: 'admin.project',
    api_route_prefix: 'admin.project',
})

const orderConstants = constants({
    title: '発注',
    route_prefix: 'admin.order',
    api_route_prefix: 'admin.order',
})


const materialConstants = constants({
    title: '材料データ',
    route_prefix: 'admin.material',
    api_route_prefix: 'admin.material',
})


const userConstants = constants({
    title: '仕入先',
    route_prefix: 'admin.user',
    api_route_prefix: 'admin.user',
})

const customerConstants = constants({
    title: '顧客',
    route_prefix: 'admin.customer',
    api_route_prefix: 'admin.customer',
})


const estimateConstants = constants({
    title: '見積り',
    route_prefix: 'admin.estimate',
    api_route_prefix: 'admin.estimate',
})

const productConstants = constants({
    title: '品目',
    route_prefix: 'admin.product',
    api_route_prefix: 'admin.product',
})



export default constants

export {
    projectConstants,
    orderConstants,
    materialConstants,
    userConstants,
    estimateConstants,
    customerConstants,
    productConstants,
}