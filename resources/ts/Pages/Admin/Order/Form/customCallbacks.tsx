import { FieldInputFormProps } from "blu/Components/types/Field"
import * as user_constants from "../../User/constants"
import IndexChoiceForm from "@/Components/Reference/IndexChoiceForm"
import Input from "blu/Components/Form/Field/Input"
import axios from 'axios'
import { useState } from "react"
import { toast } from "react-toastify"
import Select from "blu/Components/Form/Field/Select"
import BelongsTo from "blu/Components/Form/Field/BelongsTo"
import {} from "lodash"

declare var route

const customCallbacks = ({
    data,
}) =>
{
    return {
        'user': (props: FieldInputFormProps) => {
            const {
                config,
                fieldKey,
                fieldConfig,
                data,
                setData,
                fieldData,
                setFieldData,
            } = props
            const userProps = JSON.parse(JSON.stringify(props)) // 必要
            const newFieldConfig = {...fieldConfig}
            if (props.data.product && userProps.data.product.user)
            {
                // userProps.config.user.options = Object.assign(userProps.config.user.options, userProps.data.product.user)
                newFieldConfig.options = Object.assign(userProps.config.user.options, userProps.data.product.user)
            }

            console.log('data',data)

            return <BelongsTo
                config={config}
                fieldKey={fieldKey}
                fieldConfig={newFieldConfig}
                data={data}
                setData={setData}
                fieldData={fieldData}
                setFieldData={setFieldData}
            />
        },
    }
}

export default customCallbacks