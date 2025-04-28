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

declare var route

const formCustomCallbacks = ({
    materialConfigs,
}) =>
{
    return {

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