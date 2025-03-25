import { FieldInputFormProps } from "blu/Components/types/Field"
import * as user_constants from "../../User/constants"
import IndexChoiceForm from "@/Components/Reference/IndexChoiceForm"
import Input from "blu/Components/Form/Field/Input"
import axios from 'axios'
import { useState } from "react"
import { toast } from "react-toastify"



const customCallbacks = ({
    userConfigs,
}) =>
{
    return {
        'user': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            return <IndexChoiceForm
                modalTitle='仕入れ先 - 参照'
                apiUrl={route(user_constants.API_ROUTE)}
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

const Product = ({}) =>
{
    return <>test</>
}

export default Product