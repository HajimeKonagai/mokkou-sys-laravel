import { FieldInputFormProps } from "blu/Components/types/Field"
import IndexChoiceForm from "@/Components/Reference/IndexChoiceForm"
import { estimateConstants, materialConstants, productConstants } from "@/Components/constantas"
import Page from "@/Components/Page"
import Layout from '@/Layouts/AdminLayout'
import { useEffect } from "react"
import Input from "blu/Components/Form/Field/Input"
import IndexReferenceForm from "@/Components/Reference/IndexReferenceForm"
import Raw from "blu/Components/Form/Field/Raw"

declare var route

const formCustomCallbacks = ({
    productConfigs,
    materialConfigs
}) =>
{
    return {
        'total': (props: FieldInputFormProps) => {
            const { config, data, setData } = props

            if ('estimate_product' in data)
            {
                useEffect(() => {
                    let total = 0
                    data.estimate_product.map((ep) => {
                        if (ep.total)
                        {
                            total += ep.total
                        }
                    })
                    setData({...data, ...{
                        total: total 
                    }})
                }, [data.estimate_product])
            }
            else
            {
                useEffect(() => {
                    const price = data.price ? data.price : 0
                    const quantity = data.quantity ? data.quantity: 0
                    setData({...data, ...{
                        total: price * quantity 
                    }})
                }, [data.quantity, data.price])
            }

            // console.log('config', props, config)

            return <Raw {...props} />
        },

        'price': (props: FieldInputFormProps) => {
            const { config, fieldConfig, data, setData } = props

            if (fieldConfig._calcMaterials )
            {
                useEffect(() => {
                    const price = data.product_material && data.product_material.reduce((sum, val) => {
                        return sum + (val && val.total ? val.total : 0)
                    }, 0) || 0
                    console.log('val',  price)

                    setData({...data, ...{
                        price: price 
                    }})

                }, [data.product_material])
            }
                
            return fieldConfig._calcMaterials && (
                <Raw {...props} />
            ) || (
                <Input  {...props} />
            )
        },

        'product': (props: FieldInputFormProps) => {
            const { config, data, setData } = props
            const apiUrl = data.user ? route(productConstants.API_ROUTE, {user_id: data.user.id}) : route(productConstants.API_ROUTE)
    
            return <IndexReferenceForm
                modalTitle='品目 - 参照'
                apiUrl={apiUrl}
                fieldKey={'product'}
                config={config}
                data={data}
                setData={setData}
                referenceConfigs={productConfigs}
                index_preference_key={productConstants.INDEX_PREFERENCE_KEY}
                search_preference_key={productConstants.SEARCH_PREFERENCE_KEY}
            />
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
    

    }
}

const Estimate = ({
    configs,
    productConfigs,
    materialConfigs
}) =>
{
    const {
        TITLE, TITLE_INDEX, CLASS_NAME
    } = estimateConstants


    const formCallbacks = formCustomCallbacks({
        productConfigs,
        materialConfigs
    })

    return (<Layout
        title={`${TITLE} - ${TITLE_INDEX}`}
        className={`${CLASS_NAME} index`}
    >
        <Page
            configs={configs}
            constants={estimateConstants}
            createCallbacks={formCallbacks}
            editCallbacks={formCallbacks}
        />
    </Layout>)
}

export default Estimate