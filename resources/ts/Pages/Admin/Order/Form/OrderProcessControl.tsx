import { Link, usePage } from '@inertiajs/react';
import { useQueryClient } from 'react-query';
import ArrowForwardIcon from '@mui/icons-material/ArrowForward';
import ArrowBackIcon from '@mui/icons-material/ArrowBack';

declare var route

const OrderProcessControl = ({
    data
}) =>
{
    const { props } = usePage()
    const { mokkou } = props

    const queryClient = useQueryClient()

    return (<div className="OrderProcessControl">

        {data.status == 0 && (<Link
            href={route('admin.order_process.order', {order: data.id})}
            method="post"
            as="button"
            preserveScroll={true}
            onFinish={() => queryClient.invalidateQueries()}
            className="button primary small"
        >
            発注
            <ArrowForwardIcon />
        </Link>)}


        {data.status == 1 && (<div className="button-group">
            <Link
                href={route('admin.order_process.cancel', {order: data.id})}
                method="post"
                as="button"
                preserveScroll={true}
                onFinish={() => queryClient.invalidateQueries()}
                className="button danger small outline"
            >
                <ArrowBackIcon />
                取消
            </Link>
            <Link
                href={route('admin.order_process.delivered', {order: data.id})}
                method="post"
                as="button"
                preserveScroll={true}
                onFinish={() => queryClient.invalidateQueries()}
                className="button primary small"
            >
                納品済
                <ArrowForwardIcon />
            </Link>
        </div>)}

        <ul className="status flex items-center my-2 text-xs">
            {Object.keys(mokkou.order_status).map((key) => (
                <li key={key} className="flex items-center text-sm">
                    <span className={`border rounded text-xs p-1 text-center w-10 ${
                            key == data.status ? (
                                data.status == 0 && 'text-white bg-gray-600 font-bold' ||
                                data.status == 1 && 'text-white bg-orange-600 font-bold' ||
                                data.status == 2 && 'text-white bg-green-600 font-bold'
                            )
                                : 'text-gray-400'
                        }`}>
                        {mokkou.order_status[key]}
                    </span>
                    {key != 2 &&(<ArrowForwardIcon className="text-gray-300 w-1" />)}
                </li>
            ))}
        </ul>

        <div className="ordered_at text-sm">
            <span className="text-gray-600 text-xs">発注日時:</span>
            {data.ordered_at}
        </div>

    </div>)
}

export default OrderProcessControl