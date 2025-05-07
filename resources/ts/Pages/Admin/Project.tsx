import { FieldInputFormProps } from "blu/Components/types/Field"
import * as user_constants from "./_bk/User/constants"
import IndexChoiceForm from "@/Components/Reference/IndexChoiceForm"
import { projectConstants, orderConstants } from "@/Components/constantas"
import { PreferenceApi, PreferenceLocalStorage } from 'blu/Components/Preference/Save'
import Page from "@/Components/Page"
import Layout from '@/Layouts/AdminLayout'
import Table from "blu/Components/Index/Table"
import Pagination from "blu/Laravel/Pagination"
import EditModal from "@/Components/PageComponents/Edit"
import CreateModal from "@/Components/PageComponents/Create"
import ShowModal from "@/Components/PageComponents/Show"
import DeleteButton from "@/Components/PageComponents/Delete"
import ShowIcon from '@mui/icons-material/Visibility';
import CheckCircleOutlineIcon from '@mui/icons-material/CheckCircleOutline';
import ListIcon from '@mui/icons-material/List';
import { Link } from "@inertiajs/react"

declare var route

const formCustomCallbacks = ({
}) =>
{
    return {
    }
}

const viewCustomCallbacks = ({
    orderConfigs,
}) =>
{
    return {
        'order': (props: FieldInputFormProps) => {
            const { config, data, setData, fieldKey } = props

            const indexPreference = PreferenceLocalStorage({
                storageKey: orderConstants.INDEX_PREFERENCE_KEY,
                defaultPreference: orderConfigs.index
            })

            return (Array.isArray(data.order) && (<>
                <Table
                    config={orderConfigs.config}
                    preference={[
                        'deadline_at',
                        // 'id',
                        'detail',
                    ]}
                    isLoading={false}
                    data={data.order}
                    searchParams={[]}
                    setSearchParams={null}
                />
                
            </>))
        },
    }
}

const Control = ({
    data,
    constants,
}) => {

    return (<div className='button-group'>
        {/*
        <Link
            className="button small blue outline"
            href={route('admin.session.put_project', {project: data.id})}
            method={`put`}
        ><CheckCircleOutlineIcon />選択</Link>
        */}
        <Link
            className="button small edit"
            href={route('admin.project.to_task', { project: data.id })}
            method={`put`}
        ><ListIcon />詳細・編集</Link>
        <DeleteButton
            item={data}
            constants={constants}
        />
    </div>)
}

const Project = ({
    configs,
    orderConfigs
}) =>
{
    const {
        TITLE, TITLE_INDEX, CLASS_NAME, CONTROL_NAME
    } = projectConstants


    const formCallbacks = formCustomCallbacks({
    })

    const viewCallbacks = viewCustomCallbacks({
        orderConfigs
    })


    const customCells = {
        '_control': {
            type: Control,
            props: {
                editConfigs: configs,
                constants: projectConstants,
                editCallbacks: formCallbacks,
                showCallbacks: viewCallbacks,
            },
            label: CONTROL_NAME
        },
    }

    return (<Layout
        title={`${TITLE} - ${TITLE_INDEX}`}
        className={`${CLASS_NAME} index`}
    >
        <Page
            configs={configs}
            constants={projectConstants}
            showCallbacks={viewCallbacks}
            customCells={customCells}
        />
    </Layout>)
}

export default Project