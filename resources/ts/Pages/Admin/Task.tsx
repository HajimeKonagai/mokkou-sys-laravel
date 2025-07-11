import { FieldInputFormProps } from "blu/Components/types/Field"
import IndexChoiceForm from "@/Components/Reference/IndexChoiceForm"
import { taskConstants, materialConstants, productConstants } from "@/Components/constantas"
import Page from "@/Components/Page"
import Layout from '@/Layouts/AdminLayout'
import { useEffect } from "react"
import Input from "blu/Components/Form/Field/Input"
import IndexReferenceForm from "@/Components/Reference/IndexReferenceForm"
import Raw from "blu/Components/Form/Field/Raw"
import { useModalContext } from "blu/ContextComponents/Modal"
import { PreferenceLocalStorage } from "blu/Components/Preference/Save"
import useSearch from "blu/Laravel/classes/useSearch"
import { OpenIndexPreferenceSetting, OpenSearchPreferenceSetting } from "blu/Components/Preference/Setting"
import SearchFields from "blu/Components/Index/SearchFields"
import CreateModal from "@/Components/PageComponents/Create"
import Pagination from "blu/Laravel/Pagination"
import { ViewContextProvider } from "blu/Components/View/Fields"
import Table from "blu/Components/Index/Table"
import { Link, usePage } from "@inertiajs/react"
import ProjectSection from "@/Components/Admin/ProjectSection"
import ShowModal from "@/Components/PageComponents/Show"
import EditModal from "@/Components/PageComponents/Edit"
import DeleteButton from "@/Components/PageComponents/Delete"
import ContentCopyIcon from '@mui/icons-material/ContentCopy';
import ArrowUpwardIcon from '@mui/icons-material/ArrowUpward';
import ArrowDownwardIcon from '@mui/icons-material/ArrowDownward';
import { useQueryClient } from "react-query"
import Bulk from "@/Components/Admin/Bulk"
declare var route
const SeqControl = ({
    data
}) =>
{
    const queryClient = useQueryClient()
    return (<div className='button-group'>
        <Link
            className="button small green"
            href={route('admin.task.seq_decrease', {id: data.id})}
            method={'put'}
            preserveScroll={true}
            onFinish={() => {
                queryClient.invalidateQueries()
            }}
        >
            <ArrowUpwardIcon />
        </Link>
        <Link
            className="button small green"
            href={route('admin.task.seq_increase', {id: data.id})}
            method={'put'}
            preserveScroll={true}
            onFinish={() => {
                queryClient.invalidateQueries()
            }}
        >
            <ArrowDownwardIcon />
        </Link>
    </div>)
}

const Control = ({
    data,
    editConfigs,
    showConfigs,
    constants,
    editCallbacks,
    showCallbacks,
}) =>
{
    const queryClient = useQueryClient()
    return (<>

        <div className='button-group'>
            <ShowModal
                item={data}
                configs={showConfigs}
                constants={constants}
                showCallbacks={showCallbacks}
                editCallbacks={editCallbacks}
            />
            <Link
                className="button small green"
                href={route('admin.task.duplicate', {id: data.id})}
                method={'put'}
                preserveScroll={true}
                onFinish={() => {
                    queryClient.invalidateQueries()
                }}
            >
                <ContentCopyIcon />
                複製
            </Link>
            <EditModal
                item={data}
                configs={editConfigs}
                constants={constants}
                editCallbacks={editCallbacks}
            />
            <DeleteButton
                item={data}
                constants={constants}
            />
        </div>
    </>)
}

const formCustomCallbacks = ({
    productConfigs,
    materialConfigs,
    project,
}) =>
{
    return {
        'total': (props: FieldInputFormProps) => {
            const { config, data, setData } = props

            useEffect(() =>
            {
                console.log('total use effect ')
                const price = data.price ? data.price : 0
                const quantity = data.quantity ? data.quantity: 0
                // bulk でくることがあるので、prev を使えない
                if (price * quantity == 0) return
                setData({...data,
                    ...{
                        total: price * quantity 
                    }
                })
            }, [data.quantity, data.price])
        
            return <Raw {...props} />
        },

        
        'material_cost': (props: FieldInputFormProps) =>
        {
            const { config, fieldConfig, data, setData } = props

            useEffect(() => {
                const price = data.task_material && data.task_material.reduce((sum, val) => {
                    return sum + (val && val.total ? val.total : 0)
                }, 0) || 0

                setData((prev) => {
                    return {...prev, ...{
                        material_cost: price 
                }}})

            }, [data.task_material])

            console.log('project', project)
            useEffect(() =>
            {
                const net_rate = project && project.net_rate ? Number(project.net_rate) : config.net_rate.default
                console.log('init', net_rate)
                setData((prev) => {
                    return {...prev, ...{
                        net_rate : net_rate,
                }}})
            }, [])

            useEffect(() => 
            {
                const material_cost = isNaN(data.material_cost) ? 0: Number(data.material_cost)
                const process_cost  = isNaN(data.process_cost ) ? 0: Number(data.process_cost )
                const attach_cost   = isNaN(data.attach_cost  ) ? 0: Number(data.attach_cost  )
                const rate          = isNaN(data.rate         ) ? 0: Number(data.rate         )
                const net_rate      = isNaN(data.net_rate     ) ? 0: Number(data.net_rate     )

                const aux_cost = (material_cost + process_cost) * 0.05
                const cost_total = material_cost + process_cost + aux_cost + attach_cost
                const raw_price = cost_total / rate
                const price = Math.ceil( (raw_price / net_rate) / 100) * 100

                setData((prev) => {
                    return {...prev, ...{
                        aux_cost : aux_cost,
                        cost_total: cost_total,
                        raw_price: raw_price,
                        price: price
                }}})
            }, [
                data.material_cost,
                data.process_cost,
                data.attach_cost,
                data.rate,
            ])

                
            return <Raw {...props} />
        },

        // raw だと保存されないので、number → raw に変換
        'aux_cost': (props: FieldInputFormProps) => { return <Raw {...props} /> },
        'cost_total': (props: FieldInputFormProps) => { return <Raw {...props} /> },
        'raw_price': (props: FieldInputFormProps) => { return <Raw {...props} /> },
        'price': (props: FieldInputFormProps) => { return <Raw {...props} /> },
        'net_rate': (props: FieldInputFormProps) => { return <Raw {...props} /> },

        'product': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            const apiUrl = data.user ? route(productConstants.API_ROUTE, {user_id: data.user.id}) : route(productConstants.API_ROUTE)
    
            return <IndexReferenceForm
                modalTitle='品目 - 参照'
                apiUrl={apiUrl}
                fieldKey={'product'}
                config={config}
                data={data}
                setData={setData}
                referenceConfigs={productConfigs}
                index_preference_key={productConstants.INDEX_PREFERENCE_KEY}
                search_preference_key={productConstants.SEARCH_PREFERENCE_KEY}
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
        'task_material': (props: FieldInputFormProps) => {
            const { fieldConfig, fieldData, setFieldData, fieldErrors } = props

            return (<div className={`HasMany`}>
                <Bulk
                    name={'task_material'}
                    tag={fieldConfig.hasMany.tag ?? 'table'}
                    config={fieldConfig.hasMany.config}
                    bulkData={fieldData}
                    setBulkData={setFieldData}
                    bulkErrors={fieldErrors}
                    addButtonText={'addButtonText' in fieldConfig ? fieldConfig.addButtonText:'新規列を追加'}
                />
            </div>)
        }, 
    }
}


const Task = ({
    viewConfigs,
    formConfigs,
    productConfigs,
    materialConfigs
}) =>
{
    const  { props } = usePage()
    const { project } = props

    const {
        TITLE, TITLE_INDEX, CLASS_NAME
    } = taskConstants

    const { API_ROUTE, SEARCH_PREFERENCE_KEY, INDEX_PREFERENCE_KEY, CONTROL_NAME } = taskConstants

    const searchConfigs = viewConfigs
    const indexConfigs  = viewConfigs
    const showConfigs   = viewConfigs
    const createConfigs = formConfigs
    const editConfigs   = formConfigs

    // const searchPreference = PreferenceApi({
    // apiUrl: route('api.preference.get', {key: SEARCH_PREFERENCE_KEY}),
    const searchPreference = PreferenceLocalStorage({
        storageKey: SEARCH_PREFERENCE_KEY,
        defaultPreference: searchConfigs.search
    })

    // const indexPreference = PreferenceApi({
        // apiUrl: route('api.preference.get', {key: INDEX_PREFERENCE_KEY}),
    const indexPreference = PreferenceLocalStorage({
        storageKey: INDEX_PREFERENCE_KEY,
        defaultPreference: indexConfigs.index
    })


    const replaceState = true
    const { searchParams, setSearchParams, results } = useSearch({
        apiUrl: route(API_ROUTE),
        replaceState: replaceState,
    })

    const formCallbacks = formCustomCallbacks({
        productConfigs,
        materialConfigs,
        project
    })
    const viewCallbakcs = {}

    
    const forceCustomrCells = true
    const customCells = {
        '_seq_control': {
            type: SeqControl,
            props: {},
            label: '並べ替え'
        },
        '_control': {
            type: Control,
            props: {
                editConfigs,
                showConfigs,
                constants: taskConstants,
                editCallbacks: formCallbacks,
                showCallbacks: {},
            },
            label: CONTROL_NAME
        },
    }
    const configForIndex = indexConfigs.config

    return (<Layout
        title={`${project ? project.name : '現場未選択'} - ${TITLE} - ${TITLE_INDEX}`}
        className={`${CLASS_NAME} index`}
    >
        <ProjectSection />

        {project && (<>

            {/*
            <section className='search'>
                <header>
                    <h1>{TITLE} - 検索</h1>
                    {(searchPreference && 'preference' in searchPreference) && (
                    <OpenSearchPreferenceSetting
                        config={searchConfigs.config}
                        preference={searchPreference.preference}
                        setPreference={searchPreference.storePreference}
                        deletePreference={searchPreference.deletePreference}
                    />)}
                </header>
                <div className="content">
                    <SearchFields
                        config={searchConfigs.config}
                        data={searchParams}
                        setData={setSearchParams}
                        preference={searchPreference && 'preference' in searchPreference ?
                            searchPreference.preference :
                            Array.isArray(searchPreference) ? searchPreference : []
                        }
                    />
                </div>
            </section>
            */}


            <section className='index'>
                <header>
                    <h1>{TITLE} - 一覧</h1>
                    {(indexPreference && 'preference' in indexPreference) && (
                    <OpenIndexPreferenceSetting
                        config={configForIndex}
                        preference={indexPreference.preference}
                        setPreference={indexPreference.storePreference}
                        deletePreference={indexPreference.deletePreference}
                    />)}
                </header>
                <header>
                    <CreateModal
                        configs={createConfigs}
                        constants={taskConstants}
                        createCallbacks={formCallbacks}
                        editCallbacks={formCallbacks}
                    />
                </header>

                <div className='content'>
                    <Pagination
                        data={results.data}
                        setSearchParams={setSearchParams}
                        isLoading={results.isLoading}
                    />
                    <ViewContextProvider
                        callbacks={viewCallbakcs}
                    >
                        <Table
                            config={configForIndex}
                            preference={indexPreference && 'preference' in indexPreference ?
                                indexPreference.preference :
                                Array.isArray(indexPreference) ? indexPreference : []
                            }
                            isLoading={results.isLoading}
                            data={results.data?.data}
                            searchParams={searchParams}
                            setSearchParams={setSearchParams}
                            customCells={customCells}
                            forceCustomrCells={forceCustomrCells}
                        />
                    </ViewContextProvider>

                    <Pagination
                        data={results.data}
                        setSearchParams={setSearchParams}
                        isLoading={results.isLoading}
                    />
                </div>
                <footer style={{justifyContent: 'start'}}>
                    <CreateModal
                        configs={createConfigs}
                        constants={taskConstants}
                        createCallbacks={formCallbacks}
                        editCallbacks={formCallbacks}
                    />
                    <span></span>
                </footer>
            </section>
        </>) || (<>

            

        </>)}
    </Layout>)

    return (<Layout
        title={`${TITLE} - ${TITLE_INDEX}`}
        className={`${CLASS_NAME} index`}
    >
        <Page
            configs={configs}
            constants={taskConstants}
            createCallbacks={formCallbacks}
            editCallbacks={formCallbacks}
        />
    </Layout>)
}

export default Task