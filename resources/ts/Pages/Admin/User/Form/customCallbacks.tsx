import { FieldInputFormProps } from "blu/Components/types/Field"
import * as product_constants from "../../Product/constants"
import IndexChoiceForm from "@/Components/Reference/IndexChoiceForm"

declare var route

const customCallbacks = ({
    productConfigs,
}) => {

    return {
        'product': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            return <IndexChoiceForm
                modalTitle='材料データ - 参照'
                apiUrl={route(product_constants.API_ROUTE)}
                fieldKey={'product'}
                config={config}
                data={data}
                setData={setData}
                referenceConfigs={productConfigs}
                index_preference_key={product_constants.INDEX_PREFERENCE_KEY}
                search_preference_key={product_constants.SEARCH_PREFERENCE_KEY}
            />
        },

    }
}

export default customCallbacks