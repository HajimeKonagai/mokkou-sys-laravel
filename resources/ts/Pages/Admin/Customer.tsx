import { FieldInputFormProps } from "blu/Components/types/Field"
import IndexChoiceForm from "@/Components/Reference/IndexChoiceForm"
import { customerConstants, userConstants } from "@/Components/constantas"
import Page from "@/Components/Page"
import Layout from '@/Layouts/AdminLayout'

declare var route

const formCustomCallbacks = ({
}) =>
{
    return {
    }
}

const Material = ({
    configs,
    userConfigs
}) =>
{
    const {
        TITLE, TITLE_INDEX, CLASS_NAME
    } = customerConstants


    const formCallbacks = formCustomCallbacks({
    })

    return (<Layout
        title={`${TITLE} - ${TITLE_INDEX}`}
        className={`${CLASS_NAME} index`}
    >
        <Page
            configs={configs}
            constants={customerConstants}
            createCallbacks={formCallbacks}
            editCallbacks={formCallbacks}
        />
    </Layout>)
}

export default Material