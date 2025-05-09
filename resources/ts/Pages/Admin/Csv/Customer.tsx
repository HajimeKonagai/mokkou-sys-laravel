import AdminLayout from '@/Layouts/AdminLayout'
import axios from 'axios'
import { useQuery, useMutation, useQueryClient } from 'react-query'
import { useEffect, useState, useRef } from "react"


import DataTable from 'blu-csv/Components/DataTable'
import { useSetting } from 'blu-csv/Components/Setting'
import { useCsvReader } from 'blu-csv/Components/CsvReader'
import SearchField  from 'blu-csv/Components/SearchField'
import ImportFields  from 'blu-csv/Components/ImportFields'

import Encoding from 'encoding-japanese'


import 'blu-csv/sass/blu-csv.scss'
import { useStore } from 'blu/classes/apis'
import { PreferenceApi } from 'blu/Components/Preference/Save'
import { is_json } from 'blu/classes/util'
import CsvImport from './CsvImport'

const encode = (value, encoding) =>
{
    return Encoding.convert(value, {to: 'UNICODE', from: encoding})
}

const valReplace = (value, replace) =>
{
    let newValue = value.toString();
    replace.map((rep) => {
        newValue = newValue.replaceAll(rep.from, rep.to);
    });

    return newValue;
}


declare var route

const Customer = ({
    customSetting,
    toFields,
}) =>
{
    return (<AdminLayout
        title='Csv - 顧客'
    >

        <CsvImport
            customSetting={customSetting}
            toFields={toFields}

            importUrl={route('admin.csv.customer.store')}
            settingKey='csv.customer'
        />

    </AdminLayout>)
}
export default Customer
