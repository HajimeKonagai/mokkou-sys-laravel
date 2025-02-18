import { FieldInputFormProps } from "blu/Components/types/Field"
import * as user_constants from "../constants"
import Input from "blu/Components/Form/Field/Input"
import axios from 'axios'
import { useState } from "react"
import { toast } from "react-toastify"

declare var route

const customCallbacks = ({
    data,
}) => {

    return {}
}

export default customCallbacks