import Layout from '@/Layouts/AdminLayout'
import { Link } from '@inertiajs/react';
import Fields from "blu/Components/View/Fields"
import { PreferenceApi, PreferenceLocalStorage } from 'blu/Components/Preference/Save'
import { OpenFormPreferenceSetting } from 'blu/Components/Preference/Setting'
import useForm, { toastErrors } from "blu/Laravel/classes/useForm"
import EditIcon from '@mui/icons-material/ModeEdit';
import DeleteIcon from '@mui/icons-material/Delete';
import {
    TITLE,
    FORM_PREFERENCE_KEY,
    EDIT_ROUTE,
    DELETE_ROUTE,
    DELETE_MESSAGE,
    CLASS_NAME,
    TITLE_SHOW,
    CONTROL_EDIT_LABEL,
    CONTROL_DELETE_LABEL,
} from './constants'
import customCallbacks from './View/customCallbacks'
import OrderProcessControl from './Form/OrderProcessControl';

declare var route

const Show = ({
    auth,
    account,
    config,
    item,
    formConfig = ['*'],
}) =>
{
    // const formPreference = PreferenceApi({
    //     apiUrl: route('api.preference.get', {key: FORM_PREFERENCE_KEY}),
    const formPreference = PreferenceLocalStorage({
        storageKey: FORM_PREFERENCE_KEY,
        defaultPreference: formConfig
    })

    const { delete: destroy, processing } = useForm({})

    const deleteItem = () =>
    {
        if (confirm(`「id: ${item.id}」${DELETE_MESSAGE}`))
        {
            destroy(route(DELETE_ROUTE, { id: item.id } ),
            {
                onError: (e) =>
                {
                    toastErrors(e)
                }
            })
        }
    }

    return (<Layout
        auth={auth}
        account={account}
        title={`${TITLE} - ${TITLE_SHOW}「id: ${item.id}」`}
        className={`${CLASS_NAME} show`}
    >

        <section className='view show'>
            <header>

                <div className="flex items-center justify-start">
                    <h1>{`${TITLE} - ${TITLE_SHOW}「id: ${item.id}」`}</h1>
                    <OrderProcessControl
                        data={item}
                    />
                </div>

                <div className='button-group'>
                    <Link className='small button edit' href={route(EDIT_ROUTE, { id: item.id })}><EditIcon />{CONTROL_EDIT_LABEL}</Link>
                    <button className='small button delete' disabled={processing} onClick={deleteItem}><DeleteIcon />{CONTROL_DELETE_LABEL}</button>
                    <OpenFormPreferenceSetting
                        config={config}
                        preference={formPreference.preference}
                        setPreference={formPreference.storePreference}
                        deletePreference={formPreference.deletePreference}
                        item={item}
                    />
                </div>
            </header>
            <div className='content'>
                <Fields
                    config={config}
                    data={item}
                    preference={formPreference.preference}
                    callbacks={customCallbacks({})}
                />
            </div>
        </section>

    </Layout>)
}
export default Show
