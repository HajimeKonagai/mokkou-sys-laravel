import useForm, { toastErrors } from "blu/Laravel/classes/useForm"
import { useQueryClient } from "react-query"
import DeleteIcon from '@mui/icons-material/Delete';

declare var route

const DeleteButton = ({
    item,
    constants,
}) =>
{
    const { DELETE_ROUTE, DELETE_MESSAGE, CONTROL_DELETE_LABEL } = constants
    const queryClient = useQueryClient()
    const { delete: destroy, processing } = useForm({})

    const deleteItem = () =>
    {
        if (confirm(`「id: ${item.id}」${DELETE_MESSAGE}`))
        {
            destroy(route(DELETE_ROUTE, { id: item.id} ), {
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
    }

    return <button className='small button delete' disabled={processing} onClick={deleteItem}><DeleteIcon />{CONTROL_DELETE_LABEL}</button>
}

export default DeleteButton