import { useIndexModal } from "./Components/IndexModal"
import { ArrGet, isObject, toArr } from 'blu/classes/util'
import { diffs as getDiffs } from './index'
import isEqual from 'lodash.isequal'
import SimpleSearch from "./Components/SimpleSearch"

import CheckBoxIcon from '@mui/icons-material/CheckBox';
import CheckBoxOutlineBlankIcon from '@mui/icons-material/CheckBoxOutlineBlank';
import ClearIcon from '@mui/icons-material/Clear';
import { previewsByKeys } from "./Components/Preview"
import Bulk from "blu/Components/Form/Bulk"
import { defaultDataFromConfig } from "blu/classes/model"



const Previews = ({
    fieldData,
    fieldConfig,
    removeChoice,
    setFieldData
}) =>
{
    const blukConfig = fieldConfig.hasMany.config
    blukConfig[fieldConfig.HasManyUnique.unique].type = 'raw'
    return <Bulk
        config={fieldConfig.hasMany.config}
        bulkData={fieldData}
        setBulkData={setFieldData}
        bulkErrors={[]}
        addable={false}
        deletable={true}
    />
}


const ChoiceControl = ({fieldData, data: rowData, addChoice, removeChoice, fieldConfig}) =>
{
    const isChoiced = Array.isArray(fieldData) && fieldData.filter((d) => {
        return d[fieldConfig.HasManyUnique.unique].id == rowData.id
    }).length > 0

    return <>
        {isChoiced && (
            <button className='button primary min-w-20' onClick={() => removeChoice(rowData)}><CheckBoxIcon /></button>
        ) || (
            <button className='button disabled min-w-20' onClick={() => addChoice(rowData)}><CheckBoxOutlineBlankIcon /></button>
        )}
    </>
}

const HasManyUniqueForm = ({
    apiUrl,
    fieldKey,
    config,
    data,
    setData,
    setFieldData,

    // 一覧画面で使う
    referenceConfigs,
    index_preference_key,
    search_preference_key,
    modalTitle='',

    refereneceOpenLabel='一覧から選ぶ',
}) =>
{
    const fieldConfig = config[fieldKey]

    const setChoices = (choices) =>
    {
        const newData = {...data}
        if (choices.length > 0)
        {
            newData[fieldKey] = choices.filter((element, index) => {
                return choices.findIndex((e) => e[fieldConfig.HasManyUnique.unique].id == element[fieldConfig.HasManyUnique.unique].id) == index
            })
        }
        else
        {
            if (fieldKey in newData) delete newData[fieldKey]
        }
        setData(newData)
    }

    const addChoice = (rowData) =>
    {
        const newRow = defaultDataFromConfig(fieldConfig.config)
        newRow[fieldConfig.HasManyUnique.unique] = rowData
        Object.keys(fieldConfig.HasManyUnique.attribute).map((ak) => {
            newRow[ak] = newRow[fieldConfig.HasManyUnique.unique][fieldConfig.HasManyUnique.attribute[ak]]
        })
        const newChoices = Array.isArray(data[fieldKey]) ? data[fieldKey].slice() : []
        console.log('newRow', newRow)
        newChoices.push(newRow)
        setChoices(newChoices)
    }
    const removeChoice = (rowData) =>
    {
        const existRow = Array.isArray(data[fieldKey]) ? data[fieldKey].find((d) => {
            return d[fieldConfig.HasManyUnique.unique].id == rowData.id
        }) : false

        if (existRow)
        {
            let inputed = Object.keys(existRow).filter((k) => {
                if (k == fieldConfig.HasManyUnique.unique) return false
                if (fieldConfig.HasManyUnique.attribute && Object.values(fieldConfig.HasManyUnique.attribute).includes(k)) return false
                return existRow[k]
            })
            if (inputed.length > 0)
            {
                if (!confirm('入力されている値がありますが、除外してもよろしいですか？')) return
            }
        }
        const newChoices = Array.isArray(data[fieldKey]) ? data[fieldKey].filter((d) => {
            return d[fieldConfig.HasManyUnique.unique].id != rowData.id
        }) : []
        setChoices(newChoices)
    }

    const customCells = {
        '_control': {
            type: ChoiceControl,
            label: '選択',
            props: {
                fieldData: data[fieldKey],
                addChoice,
                removeChoice,
                fieldConfig
            },
        }
    }

    const { openModal, closeModal, component: modalComponent } = useIndexModal({
        apiUrl,
        referenceConfigs,
        index_preference_key,
        search_preference_key,
        customCells,
        title: modalTitle,
    })


    return (<div className='HasManyUnique HasManyUniqueForm'>


        {/* preview */}
        <Previews
            fieldData={data[fieldKey]}
            fieldConfig={fieldConfig}
            removeChoice={removeChoice}
            setFieldData={setFieldData}
        />

        <div className="Reference flex justify-start items-start">

        {/* button */}
            <div className='button-group'>
                <button className='reference button primary' onClick={openModal}>{refereneceOpenLabel}</button>
            </div>

            {/* simple search */}
            <SimpleSearch
                apiUrl={apiUrl}
                onChoice={(rowData) => {
                    addChoice(rowData)
                }}
                searchKeys={['name']}
                searchParamsDefault={ Array.isArray(data[fieldKey]) ?
                    {
                        ids_not_in: (data[fieldKey]).map((d) => d.id),
                        perPage: 5,
                    }: { prePage: 5 }
                }
            />
        </div>

        {/* modal */}
        {modalComponent}

    </div>)
}

export default HasManyUniqueForm