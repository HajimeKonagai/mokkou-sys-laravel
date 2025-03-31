import SupplierLayout from "@/Layouts/SupplierLayout"
import { useForm, usePage } from "@inertiajs/react"
import { toastErrors } from "blu/Laravel/classes/useForm"

import PageIndex from 'blu/Laravel/Page/Index'
import { useEffect, useState } from "react"
import { useQueryClient } from "react-query"
import CheckIcon from '@mui/icons-material/Check';
import { Echo } from "@/classes/echo"
import { toast } from "react-toastify"

const TITLE = '進行中の発注一覧'
const API_ROUTE = 'supplier.dashboard'

declare var route

const Control = ({ data, deadlines, setDeadlines }) =>
{
    const queryClient = useQueryClient()
    const { props } = usePage()
    const { auth } = props

    const { data: formData, setData, post, processing } = useForm({
        price: data.price,
        delivery_at: data.delivery_at,
    })
    const [forceChange, setForceChange ] = useState(false)

    const setDeliveryAt = () =>
    {
        post(route('supplier.dashboard.store', { orderDetail: data.id} ), {
            preserveScroll: true,
            preserveState: true, // 検索の維持,
            onSuccess: () =>
            {
                queryClient.invalidateQueries()
            },
            onError: (e) =>
            {
                toastErrors(e)
            }
        })
    }

    return (<div className='button-group'>
        {(!data.delivery_at || forceChange) && (<>

            <input
                type="number"
                value={formData.price}
                onChange={(e) => {
                    /*
                    const newDeedLines = {...deadlines}
                    newDeedLines[data.id] = e.target.value
                    setDeadlines(newDeedLines)
                    */

                    const newFormData = {...formData}
                    newFormData.price = e.target.value
                    setData(newFormData)
                }}
            />

            <input
                type="date"
                value={formData.delivery_at}
                onChange={(e) => {
                    /*
                    const newDeedLines = {...deadlines}
                    newDeedLines[data.id] = e.target.value
                    setDeadlines(newDeedLines)
                    */

                    const newFormData = {...formData}
                    newFormData.delivery_at = e.target.value
                    setData(newFormData)
                }}
            />
            <button className='button primary' disabled={processing} onClick={setDeliveryAt}>
                設定<CheckIcon />
            </button>
        </>) || (<>
            {data.delivery_at}
        </>)}
    </div>)
}


const Price = ({ data, deadlines, setDeadlines }) =>
    {
        const queryClient = useQueryClient()
        const { props } = usePage()
        const { auth } = props

    
        const { data: formData, setData, post, processing } = useForm({
            price: data.price,
            delivery_at: data.delivery_at,
        })
        const [forceChange, setForceChange ] = useState(false)
    
        const setDeliveryAt = () =>
        {
            post(route('supplier.dashboard.store', { orderDetail: data.id} ), {
                preserveScroll: true,
                preserveState: true, // 検索の維持,
                onSuccess: () =>
                {
                    queryClient.invalidateQueries()
                },
                onError: (e) =>
                {
                    toastErrors(e)
                }
            })
        }
    
        return (<div className='button-group'>
            {(!data.delivery_at || forceChange) && (<>
                <input
                    type="date"
                    value={formData.delivery_at}
                    onChange={(e) => {
                        /*
                        const newDeedLines = {...deadlines}
                        newDeedLines[data.id] = e.target.value
                        setDeadlines(newDeedLines)
                        */
    
                        const newFormData = {...formData}
                        newFormData.delivery_at = e.target.value
                        setData(newFormData)
                    }}
                />
                <button
                    className='button primary'
                    disabled={processing}
                    onClick={setDeliveryAt}
                >
                    設定<CheckIcon />
                </button>
            </>) || (<>
                {data.delivery_at}
            </>)}
        </div>)
    }


const Dashboard = ({
    auth,
    configs
}) =>
{
    const queryClient = useQueryClient()
    useEffect(() =>
    {
        Echo.leaveAllChannels()
        console.log(`order.${auth.user.id}`)
        Echo.private(`order.${auth.user.id}`).listen("OrderEvent", function (e)
        {
            toast(<div className="block">
                <span className="font-bold">{e.message}</span><br />
                発注番号: {e.order.code}
            </div>, {
                type: e.status,
                autoClose: false
            })
            queryClient.invalidateQueries()
        });
    }, [])

    const [deadlines, setDeadlines] = useState({})

    return (<SupplierLayout>
        <PageIndex
            config={configs.config}
            searchPreference={configs.search}
            indexPreference={configs.index}
            title={TITLE}
            apiUrl={route(API_ROUTE)}
            customCells={{
                '_control': {
                    type: Control,
                    props: {
                        deadlines,
                        setDeadlines,
                    },
                    label: <>単価・納期設定</>
                }
            }}
        />
    </SupplierLayout>)
}

export default Dashboard