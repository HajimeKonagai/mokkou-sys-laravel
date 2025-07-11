import { useIndexModal } from "./Components/IndexModal"
import { ArrGet, isObject, toArr } from 'blu/classes/util'
import { diffs as getDiffs } from './index'
import isEqual from 'lodash.isequal'
import SimpleSearch from "./Components/SimpleSearch"
import Preview from "./Components/Preview"



const exestInput = ({
    config,
    newData,
    fieldConfig,
}) =>
{
    return 'reference' in fieldConfig.IndexReference && Object.keys(fieldConfig.IndexReference.reference).filter((key) => {
        return Boolean(newData[fieldConfig.IndexReference.reference[key]]) &&
            fieldConfig.IndexReference.reference[key] in config &&
            config[fieldConfig.IndexReference.reference[key]].type &&
            config[fieldConfig.IndexReference.reference[key]].type != 'hidden'
    }).length
}



const ReferenceInputControl = ({data, inputReference, label}) =>
{
    return <button className='button primary min-w-20' onClick={() => inputReference(data)}>{label}</button>
}

const IndexReferenceForm = ({
    apiUrl,
    fieldKey,
    config,
    data,
    setData,

    // 一覧画面で使う
    referenceConfigs,
    index_preference_key,
    search_preference_key,
    modalTitle='',

    refereneceOpenLabel='参照',
    refereneceCancelLabel='解除',
    referenceInputLabel='入力',

    // Simple Search で使う
    simpleSearchParam=null,
    simpleSearchNum=3,
}) =>
{
    const fieldConfig = config[fieldKey]

    const inputReference = (fieldData) =>
    {
        if (!fieldData && !confirm('参照を解除してもよろしいですか?')) return

        const newData = {...data}
        newData[fieldKey] = fieldData ? fieldData: 'default' in config[fieldKey] ? config[fieldKey].default: ''

        if ('reference' in fieldConfig.IndexReference)
        {
            if (!exestInput({
                newData,
                config,
                fieldConfig
            }) || confirm('すでに入力された値を上書きしますか?'))
            {
                Object.keys(fieldConfig.IndexReference.reference).map((keyFrom) =>
                {
                    const keyTo = fieldConfig.IndexReference.reference[keyFrom]

                    console.log(keyTo, keyFrom)
                    if (isObject(keyTo) && 'field' in keyTo && 'reference' in keyTo)
                    {
                        const value = fieldData? ArrGet(fieldData, keyFrom) : 'default' in config[keyTo.field] ? config[keyTo].default: []
                        const valArr = []
                        value.map((v) => {
                            const valRow = {}
                            Object.keys(keyTo.reference).map((arrKeyFrom) =>
                            {
                                const arrConfig = keyTo.field in config ? config[keyTo.field] : {}
                                const arrKeyTo = keyTo.reference[arrKeyFrom]
                                const arrValue = value? ArrGet(v, arrKeyFrom) : 'default' in arrConfig[arrKeyTo] ? arrConfig[arrKeyTo].default: ''
                                valRow[arrKeyTo] = arrValue
                            })
                            valArr.push(valRow)
                        })
                        console.log('valArr', valArr)
                        newData[keyTo.field] = valArr
                    }
                    else
                    {
                        const value = fieldData? ArrGet(fieldData, keyFrom) : 'default' in config[keyTo] ? config[keyTo].default: ''
                        newData[keyTo] = value
                    }
                })
            }
        }

        console.log('newData', newData)

        setData(newData)
        closeModal()
    }

    const customCells = {
        '_control': {
            type: ReferenceInputControl,
            props: {
                inputReference: inputReference,
                label: referenceInputLabel
            },
            label: referenceInputLabel
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


    return (<div className='IndexReference IndexReferenceForm'>

        {/* button */}
        <div className='button-group'>
            <button className='reference button primary' onClick={openModal}>{refereneceOpenLabel}</button>
            {(data[fieldKey] && (!('default' in fieldConfig) || !isEqual(data[fieldKey], fieldConfig.default))) && (
                <button className='button danger' onClick={() => inputReference(null)}>{refereneceCancelLabel}</button>
            )}
        </div>

        {/* preview */}
        <Preview
            config={config}
            fieldKey={fieldKey}
            data={data}
        />

        {/* simple search */}
        <SimpleSearch
            apiUrl={apiUrl}
            onChoice={(rowData) => {
                inputReference(rowData)
            }}
            searchKeys={['name']}
        />

        {/* modal */}
        {modalComponent}


        {/* diffs */}
    </div>)
}

export default IndexReferenceForm