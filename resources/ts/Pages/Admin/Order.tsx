import { FieldInputFormProps } from "blu/Components/types/Field"
import IndexReferenceForm from "@/Components/Reference/IndexReferenceForm"
import IndexChoiceForm from "@/Components/Reference/IndexChoiceForm"
import { orderConstants, materialConstants, projectConstants, userConstants } from "@/Components/constantas"
import Page from "@/Components/Page"
import Layout from '@/Layouts/AdminLayout'
import { Link, usePage } from "@inertiajs/react"
import { useQueryClient } from "react-query"
import ArrowForwardIcon from '@mui/icons-material/ArrowForward';
import ArrowBackIcon from '@mui/icons-material/ArrowBack';
import { useEffect } from "react"

declare var route

const formCustomCallbacks = ({
    projectConfigs,
    materialConfigs,
    userConfigs,
}) =>
{
    return {
        'project': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            return <IndexReferenceForm
                modalTitle='現場 - 参照'
                apiUrl={route(projectConstants.API_ROUTE)}
                fieldKey={'project'}
                config={config}
                data={data}
                setData={setData}
                referenceConfigs={projectConfigs}
                index_preference_key={projectConstants.INDEX_PREFERENCE_KEY}
                search_preference_key={projectConstants.SEARCH_PREFERENCE_KEY}
            />
        },

        'material': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            const apiUrl = data.user ? route(materialConstants.API_ROUTE, {user_id: data.user.id}) : route(materialConstants.API_ROUTE)

            return <IndexReferenceForm
                modalTitle='材料データ - 参照'
                apiUrl={apiUrl}
                fieldKey={'material'}
                config={config}
                data={data}
                setData={setData}
                referenceConfigs={materialConfigs}
                index_preference_key={materialConstants.INDEX_PREFERENCE_KEY}
                search_preference_key={materialConstants.SEARCH_PREFERENCE_KEY}
            />
        },
        'user': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            const apiUrl = data.material ? route(userConstants.API_ROUTE, {material_id: data.material.id}) : route(userConstants.API_ROUTE)
            return <IndexReferenceForm
                modalTitle='仕入れ先 - 参照'
                apiUrl={apiUrl}
                fieldKey={'user'}
                config={config}
                data={data}
                setData={setData}
                referenceConfigs={userConfigs}
                index_preference_key={userConstants.INDEX_PREFERENCE_KEY}
                search_preference_key={userConstants.SEARCH_PREFERENCE_KEY}
            />
        },
        /*
        //  ユーザーの一括設定
        'user_set': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            useEffect(() => {
                console.log('data', data.detail)
            }, [data.detail])

        },
        */

    }
}



const OrderProcessControl = ({
    data
}) =>
{
    const { props } = usePage()
    const { mokkou } = props

    const queryClient = useQueryClient()

    return (<div className="OrderProcessControl">

        {data.status == 0 && (<Link
            href={route('admin.order_process.order', {order: data.id})}
            method="post"
            as="button"
            preserveScroll={true}
            onFinish={() => queryClient.invalidateQueries()}
            className="button primary small"
        >
            発注
            <ArrowForwardIcon />
        </Link>)}


        {data.status == 1 && (<div className="button-group">
            <Link
                href={route('admin.order_process.cancel', {order: data.id})}
                method="post"
                as="button"
                preserveScroll={true}
                onFinish={() => queryClient.invalidateQueries()}
                className="button danger small outline"
            >
                <ArrowBackIcon />
                取消
            </Link>
            <Link
                href={route('admin.order_process.delivered', {order: data.id})}
                method="post"
                as="button"
                preserveScroll={true}
                onFinish={() => queryClient.invalidateQueries()}
                className="button primary small"
            >
                納品済
                <ArrowForwardIcon />
            </Link>
        </div>)}

        <ul className="status flex items-center my-2 text-xs">
            {Object.keys(mokkou.order_status).map((key) => (
                <li key={key} className="flex items-center text-sm">
                    <span className={`border rounded text-xs p-1 text-center w-10 ${
                            key == data.status ? (
                                data.status == 0 && 'text-white bg-gray-600 font-bold' ||
                                data.status == 1 && 'text-white bg-orange-600 font-bold' ||
                                data.status == 2 && 'text-white bg-green-600 font-bold'
                            )
                                : 'text-gray-400'
                        }`}>
                        {mokkou.order_status[key]}
                    </span>
                    {key != 2 &&(<ArrowForwardIcon className="text-gray-300 w-1" />)}
                </li>
            ))}
        </ul>

        <div className="ordered_at text-sm">
            <span className="text-gray-600 text-xs">発注日時:</span>
            {data.ordered_at}
        </div>

    </div>)
}


const Order = ({
    configs,
    projectConfigs,
    materialConfigs,
    userConfigs,

    indexConfigs,
    createConfigs,
    editConfigs,
}) =>
{
    const {
        TITLE, TITLE_INDEX, CLASS_NAME
    } = orderConstants


    const formCallbacks = formCustomCallbacks({
        projectConfigs,
        materialConfigs,
        userConfigs,
    })

    return (<Layout
        title={`${TITLE} - ${TITLE_INDEX}`}
        className={`${CLASS_NAME} index`}
    >
        <Page
            configs={configs}
            constants={orderConstants}
            createCallbacks={formCallbacks}
            editCallbacks={formCallbacks}
            customCells={{
                '_order_control': {
                    type: OrderProcessControl,
                    props: {},
                    label: '発注処理',
                },
            }}
            indexConfigs={indexConfigs}
            createConfigs={createConfigs}
            editConfigs={editConfigs}
        />
    </Layout>)
}

export default Order