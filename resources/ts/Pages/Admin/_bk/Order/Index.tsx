import Layout from '@/Layouts/AdminLayout'
import { useQueryClient } from 'react-query';
import { Link } from '@inertiajs/react';
import PageIndex from 'blu/Laravel/Page/Index'
import useForm, { toastErrors } from "blu/Laravel/classes/useForm"
import { PreferenceApi, PreferenceLocalStorage } from 'blu/Components/Preference/Save'
import ShowIcon from '@mui/icons-material/Visibility';
import EditIcon from '@mui/icons-material/ModeEdit';
import DeleteIcon from '@mui/icons-material/Delete';
import {
    TITLE,
    INDEX_PREFERENCE_KEY,
    SEARCH_PREFERENCE_KEY,
    API_ROUTE,
    SHOW_ROUTE,
    EDIT_ROUTE,
    DELETE_ROUTE,
    DELETE_MESSAGE,
    CLASS_NAME,
    TITLE_INDEX,
    CONTROL_NAME,
    CONTROL_SHOW_LABEL,
    CONTROL_EDIT_LABEL,
    CONTROL_DELETE_LABEL,
} from './constants'
import customCallbacks from './View/customCallbacks';
import OrderProcessControl from './View/OrderProcessControl';


declare var route


const Control = ({ data }) =>
{
    const queryClient = useQueryClient()
    const { delete: destroy, processing } = useForm({})

    const deleteItem = () =>
    {
        if (confirm(`「id: ${data.id}」${DELETE_MESSAGE}`))
        {
            destroy(route(DELETE_ROUTE, { id: data.id} ), {
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

    return (<div className='button-group-vertical'>
        <Link className='small button view' href={route(SHOW_ROUTE, { id: data.id })}><ShowIcon />表示</Link>
        <Link className='small button edit' href={route(EDIT_ROUTE, { id: data.id })}><EditIcon />{CONTROL_EDIT_LABEL}</Link>
        <button className='small button delete' disabled={processing} onClick={deleteItem}><DeleteIcon />{CONTROL_DELETE_LABEL}</button>
    </div>)
}


const Index = ({
    config,
    searchConfig = [],
    indexConfig = [],
}) =>
{
    // const searchPreference = PreferenceApi({
        // apiUrl: route('api.preference.get', {key: SEARCH_PREFERENCE_KEY}),
    const searchPreference = PreferenceLocalStorage({
        storageKey: SEARCH_PREFERENCE_KEY,
        defaultPreference: searchConfig
    })

    // const indexPreference = PreferenceApi({
        // apiUrl: route('api.preference.get', {key: INDEX_PREFERENCE_KEY}),
    const indexPreference = PreferenceLocalStorage({
        storageKey: INDEX_PREFERENCE_KEY,
        defaultPreference: indexConfig
    })

    return (<Layout
        title={`${TITLE} - ${TITLE_INDEX}`}
        className={`${CLASS_NAME} index`}
    >

        <PageIndex
            config={config}
            searchPreference={searchPreference}
            indexPreference={indexPreference}
            title={TITLE}
            apiUrl={route(API_ROUTE)}
            customCells={{
                '_order_control': {
                    type: OrderProcessControl,
                    props: {},
                    label: '発注処理',
                },
                '_control': {
                    type: Control,
                    props: {},
                    label: CONTROL_NAME
                },
            }}
            callbacks={customCallbacks({})}
        />
    </Layout>)
}

export default Index
