import { FieldInputFormProps } from "blu/Components/types/Field"
import * as user_constants from "./_bk/User/constants"
import IndexChoiceForm from "@/Components/Reference/IndexChoiceForm"
import { projectConstants, orderConstants } from "@/Components/constantas"
import { PreferenceApi, PreferenceLocalStorage } from 'blu/Components/Preference/Save'
import Page from "@/Components/Page"
import Layout from '@/Layouts/AdminLayout'
import Table from "blu/Components/Index/Table"
import Pagination from "blu/Laravel/Pagination"

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

const Project = ({
    configs,
    orderConfigs
}) =>
{
    const {
        TITLE, TITLE_INDEX, CLASS_NAME
    } = projectConstants


    const formCallbacks = formCustomCallbacks({
    })

    const viewCallbacks = viewCustomCallbacks({
        orderConfigs
    })

    return (<Layout
        title={`${TITLE} - ${TITLE_INDEX}`}
        className={`${CLASS_NAME} index`}
    >
        <Page
            configs={configs}
            constants={projectConstants}
            showCallbacks={viewCallbacks}
        />
    </Layout>)
}

export default Project