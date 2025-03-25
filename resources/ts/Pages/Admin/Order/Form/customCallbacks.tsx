import { FieldInputFormProps } from "blu/Components/types/Field"
import IndexReferenceForm from "@/Components/Reference/IndexReferenceForm"
import * as project_constants from "../../Project/constants"
import * as product_constants from "../../Product/constants"
import * as user_constants from "../../User/constants"


import {} from "lodash"

declare var route

const customCallbacks = ({
    projectConfigs,
    productConfigs,
    userConfigs,
}) =>
{
    return {
        'project': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            return <IndexReferenceForm
                modalTitle='現場 - 参照'
                apiUrl={route(project_constants.API_ROUTE)}
                fieldKey={'project'}
                config={config}
                data={data}
                setData={setData}
                referenceConfigs={projectConfigs}
                index_preference_key={project_constants.INDEX_PREFERENCE_KEY}
                search_preference_key={project_constants.SEARCH_PREFERENCE_KEY}
            />
        },

        'product': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            const apiUrl = data.user ? route(product_constants.API_ROUTE, {user_id: data.user.id}) : route(product_constants.API_ROUTE)
            return <IndexReferenceForm
                modalTitle='材料データ - 参照'
                apiUrl={apiUrl}
                fieldKey={'product'}
                config={config}
                data={data}
                setData={setData}
                referenceConfigs={productConfigs}
                index_preference_key={product_constants.INDEX_PREFERENCE_KEY}
                search_preference_key={product_constants.SEARCH_PREFERENCE_KEY}
            />
        },
        'user': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            const apiUrl = data.product ? route(user_constants.API_ROUTE, {product_id: data.product.id}) : route(user_constants.API_ROUTE)
            return <IndexReferenceForm
                modalTitle='仕入れ先 - 参照'
                apiUrl={apiUrl}
                fieldKey={'user'}
                config={config}
                data={data}
                setData={setData}
                referenceConfigs={userConfigs}
                index_preference_key={user_constants.INDEX_PREFERENCE_KEY}
                search_preference_key={user_constants.SEARCH_PREFERENCE_KEY}
            />
        },
    }
}

export default customCallbacks