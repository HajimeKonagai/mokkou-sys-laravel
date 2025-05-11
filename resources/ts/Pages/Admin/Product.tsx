import { FieldInputFormProps } from "blu/Components/types/Field"
import IndexChoiceForm from "@/Components/Reference/IndexChoiceForm"
import { productConstants, materialConstants } from "@/Components/constantas"
import Page from "@/Components/Page"
import Layout from '@/Layouts/AdminLayout'
import HasManyUniqueForm from "@/Components/Reference/HasManyUniqueForm"
import IndexReferenceForm from "@/Components/Reference/IndexReferenceForm"
import { useEffect } from "react"
import Input from "blu/Components/Form/Field/Input"
import Raw from "blu/Components/Form/Field/Raw"
import Bulk from "@/Components/Admin/Bulk"

declare var route

const formCustomCallbacks = ({
    materialConfigs,
}) =>
{
    return {
        'total': (props: FieldInputFormProps) => {
            const { config, data, setData } = props

            useEffect(() => {
                const price = data.price ? data.price : 0
                const quantity = data.quantity ? data.quantity: 0
                setData({...data, ...{
                    total: price * quantity 
                }})
            }, [data.quantity, data.price])

            return <Raw {...props} />
        },
        'product_material': (props: FieldInputFormProps) => {
            const { fieldConfig, fieldData, setFieldData, fieldErrors } = props

            return (<div className={`HasMany`}>
                <Bulk
                    name={'task_material'}
                    tag={fieldConfig.hasMany.tag ?? 'table'}
                    config={fieldConfig.hasMany.config}
                    bulkData={fieldData}
                    setBulkData={setFieldData}
                    bulkErrors={fieldErrors}
                    addButtonText={'addButtonText' in fieldConfig ? fieldConfig.addButtonText:'新規列を追加'}
                />
            </div>)
        }, 

        'material': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            const apiUrl = data.user ? route(materialConstants.API_ROUTE, {user_id: data.user.id}) : route(materialConstants.API_ROUTE)

            return <IndexReferenceForm
                modalTitle='材料データ - 参照'
                apiUrl={apiUrl}
                fieldKey={'material'}
                config={config}
                data={data}
                setData={setData}
                referenceConfigs={materialConfigs}
                index_preference_key={materialConstants.INDEX_PREFERENCE_KEY}
                search_preference_key={materialConstants.SEARCH_PREFERENCE_KEY}
            />
        },


        
        'material_cost': (props: FieldInputFormProps) => {
            const { config, fieldConfig, data, setData } = props


            useEffect(() => {
                const price = data.product_material && data.product_material.reduce((sum, val) => {
                    return sum + (val && val.total ? val.total : 0)
                }, 0) || 0

                setData((prev) => {
                    return {...prev, ...{
                        material_cost: price 
                }}})

            }, [data.product_material])

            useEffect(() =>
            {
                const net_rate = data.product && data.product.net_rate ? Number(data.product.net_rate) : config.net_rate.default
                console.log('init', net_rate)
                setData((prev) => {
                    return {...prev, ...{
                        net_rate : net_rate,
                }}})
            }, [])

            useEffect(() => 
            {
                const material_cost = isNaN(data.material_cost) ? 0: Number(data.material_cost)
                const process_cost  = isNaN(data.process_cost ) ? 0: Number(data.process_cost )
                const attach_cost   = isNaN(data.attach_cost  ) ? 0: Number(data.attach_cost  )
                const rate          = isNaN(data.rate         ) ? 0: Number(data.rate         )
                const net_rate      = isNaN(data.net_rate     ) ? 0: Number(data.net_rate     )

                const aux_cost = (material_cost + process_cost) * 0.05
                const cost_total = material_cost + process_cost + aux_cost + attach_cost
                const raw_price = cost_total / rate
                const price = Math.ceil( (raw_price / net_rate) / 100) * 100

                setData((prev) => {
                    return {...prev, ...{
                        aux_cost : aux_cost,
                        cost_total: cost_total,
                        raw_price: raw_price,
                        price: price
                }}})
            }, [
                data.material_cost,
                data.process_cost,
                data.attach_cost,
                data.rate,
            ])

                
            return <Raw {...props} />
        },

        // raw だと保存されないので、number → raw に変換
        'aux_cost': (props: FieldInputFormProps) => { return <Raw {...props} /> },
        'cost_total': (props: FieldInputFormProps) => { return <Raw {...props} /> },
        'raw_price': (props: FieldInputFormProps) => { return <Raw {...props} /> },
        'price': (props: FieldInputFormProps) => { return <Raw {...props} /> },
        'net_rate': (props: FieldInputFormProps) => { return <Raw {...props} /> },

        /*
        'price': (props: FieldInputFormProps) => {
            const { config, fieldConfig, data, setData } = props

            if (fieldConfig._calcMaterials )
            {
                useEffect(() => {
                    const price = data.product_material && data.product_material.reduce((sum, val) => {
                        return sum + (val && val.total ? val.total : 0)
                    }, 0) || 0

                    setData((prev) => {
                        return {...prev, ...{
                        price: price 
                    }}})

                }, [data.product_material])
            }
                
            return fieldConfig._calcMaterials && (
                <Raw {...props} />
            ) || (
                <Input  {...props} />
            )
        },
        */

        /*
        'user': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            return <IndexChoiceForm
                modalTitle='仕入れ先 - 参照'
                apiUrl={route(userConstants.API_ROUTE)}
                fieldKey={'user'}
                config={config}
                data={data}
                setData={setData}
                referenceConfigs={userConfigs}
                index_preference_key={userConstants.INDEX_PREFERENCE_KEY}
                search_preference_key={userConstants.SEARCH_PREFERENCE_KEY}
            />
        },
        */

        /*
        'product_material': (props: FieldInputFormProps) => {
            const { config, data, setData, setFieldData } = props

            return <HasManyUniqueForm
                modalTitle='材料データデータ - 参照'
                apiUrl={route(materialConstants.API_ROUTE)}
                fieldKey={'product_material'}
                config={config}
                data={data}
                setData={setData}
                setFieldData={setFieldData}
                referenceConfigs={materialConfigs}
                index_preference_key={materialConstants.INDEX_PREFERENCE_KEY}
                search_preference_key={materialConstants.SEARCH_PREFERENCE_KEY}
            />
        },
        */
    }
}

const Product = ({
    configs,
    materialConfigs,

    indexConfigs,
    createConfigs,
    editConfigs,
}) =>
{
    const {
        TITLE, TITLE_INDEX, CLASS_NAME
    } = productConstants


    const formCallbacks = formCustomCallbacks({
        materialConfigs
    })

    return (<Layout
        title={`${TITLE} - ${TITLE_INDEX}`}
        className={`${CLASS_NAME} index`}
    >
        <Page
            configs={configs}
            constants={productConstants}
            createCallbacks={formCallbacks}
            editCallbacks={formCallbacks}

            indexConfigs={indexConfigs}
            createConfigs={createConfigs}
            editConfigs={editConfigs}
        />
    </Layout>)
}

export default Product