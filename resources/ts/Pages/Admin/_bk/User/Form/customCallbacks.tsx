import { FieldInputFormProps } from "blu/Components/types/Field"
import * as material_constants from "../../Material/constants"
import IndexChoiceForm from "@/Components/Reference/IndexChoiceForm"

declare var route

const customCallbacks = ({
    materialConfigs,
}) => {

    return {
        'material': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            return <IndexChoiceForm
                modalTitle='材料データ - 参照'
                apiUrl={route(material_constants.API_ROUTE)}
                fieldKey={'material'}
                config={config}
                data={data}
                setData={setData}
                referenceConfigs={materialConfigs}
                index_preference_key={material_constants.INDEX_PREFERENCE_KEY}
                search_preference_key={material_constants.SEARCH_PREFERENCE_KEY}
            />
        },

    }
}

export default customCallbacks