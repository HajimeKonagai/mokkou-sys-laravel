import { FieldInputFormProps } from "blu/Components/types/Field"
import IndexChoiceForm from "@/Components/Reference/IndexChoiceForm"
import { materialConstants, userConstants } from "@/Components/constantas"
import Page from "@/Components/Page"
import Layout from '@/Layouts/AdminLayout'
import HasManyUniqueForm from "@/Components/Reference/HasManyUniqueForm"

declare var route

const formCustomCallbacks = ({
    userConfigs,
}) =>
{
    return {
        /*
        'user': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            return <IndexChoiceForm
                modalTitle='仕入れ先 - 参照'
                apiUrl={route(userConstants.API_ROUTE)}
                fieldKey={'user'}
                config={config}
                data={data}
                setData={setData}
                referenceConfigs={userConfigs}
                index_preference_key={userConstants.INDEX_PREFERENCE_KEY}
                search_preference_key={userConstants.SEARCH_PREFERENCE_KEY}
            />
        },
        */

        'pricing': (props: FieldInputFormProps) => {
            const { config, data, setData, setFieldData } = props
            return <HasManyUniqueForm
                modalTitle='仕入れ先 - 参照'
                apiUrl={route(userConstants.API_ROUTE)}
                fieldKey={'pricing'}
                config={config}
                data={data}
                setData={setData}
                setFieldData={setFieldData}
                referenceConfigs={userConfigs}
                index_preference_key={userConstants.INDEX_PREFERENCE_KEY}
                search_preference_key={userConstants.SEARCH_PREFERENCE_KEY}
            />
        },
    }
}

const Material = ({
    configs,
    userConfigs
}) =>
{
    const {
        TITLE, TITLE_INDEX, CLASS_NAME
    } = materialConstants


    const formCallbacks = formCustomCallbacks({
        userConfigs
    })

    return (<Layout
        title={`${TITLE} - ${TITLE_INDEX}`}
        className={`${CLASS_NAME} index`}
    >
        <Page
            configs={configs}
            constants={materialConstants}
            createCallbacks={formCallbacks}
            editCallbacks={formCallbacks}
        />
    </Layout>)
}

export default Material