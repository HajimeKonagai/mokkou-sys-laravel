import { FieldInputFormProps } from "blu/Components/types/Field"
import IndexChoiceForm from "@/Components/Reference/IndexChoiceForm"
import { materialConstants, userConstants } from "@/Components/constantas"
import Page from "@/Components/Page"
import Layout from '@/Layouts/AdminLayout'
import HasManyUniqueForm from "@/Components/Reference/HasManyUniqueForm"

declare var route

const formCustomCallbacks = ({
    materialConfigs,
}) =>
{
    return {
        /*
        'material': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            return <IndexChoiceForm
                modalTitle={`${materialConstants.TITLE} - 参照`}
                apiUrl={route(materialConstants.API_ROUTE)}
                fieldKey={'material'}
                config={config}
                data={data}
                setData={setData}
                referenceConfigs={materialConfigs}
                index_preference_key={materialConstants.INDEX_PREFERENCE_KEY}
                search_preference_key={materialConstants.SEARCH_PREFERENCE_KEY}
            />
        },
        */

        'pricing': (props: FieldInputFormProps) => {
            const { config, data, setData, setFieldData } = props
            return <HasManyUniqueForm
                modalTitle='材料データ - 参照'
                apiUrl={route(materialConstants.API_ROUTE)}
                fieldKey={'pricing'}
                config={config}
                data={data}
                setData={setData}
                setFieldData={setFieldData}
                referenceConfigs={materialConfigs}
                index_preference_key={materialConstants.INDEX_PREFERENCE_KEY}
                search_preference_key={materialConstants.SEARCH_PREFERENCE_KEY}
            />
        },

    }
}

const User = ({
    configs,
    materialConfigs,
    createConfigs,
    editConfigs,
}) =>
{
    const {
        TITLE, TITLE_INDEX, CLASS_NAME
    } = userConstants


    const formCallbacks = formCustomCallbacks({
        materialConfigs
    })

    return (<Layout
        title={`${TITLE} - ${TITLE_INDEX}`}
        className={`${CLASS_NAME} index`}
    >
        <Page
            configs={configs}
            constants={userConstants}
            createCallbacks={formCallbacks}
            editCallbacks={formCallbacks}
            createConfigs={createConfigs}
            editConfigs={editConfigs}
        />
    </Layout>)
}

export default User