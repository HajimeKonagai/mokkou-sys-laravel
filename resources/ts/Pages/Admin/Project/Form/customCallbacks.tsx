import { FieldInputFormProps } from "blu/Components/types/Field"
import * as user_constants from "../../User/constants"
import IndexChoiceForm from "@/Components/Reference/IndexChoiceForm"
import Input from "blu/Components/Form/Field/Input"
import axios from 'axios'
import { useState } from "react"
import { toast } from "react-toastify"

declare var route

const customCallbacks = ({
    userConfigs,
}) =>
{
    return {
    }
}

export default customCallbacks