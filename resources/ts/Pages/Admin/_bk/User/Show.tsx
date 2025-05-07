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
    DELETE_ROUTE,
    DELETE_MESSAGE,
    CLASS_NAME,
    TITLE_SHOW,
} from './constants'
import customCallbacks from './View/customCallbacks'
import DeleteButton from '@/Components/PageComponents/Delete';
import constants from '@/Components/constantas';
import EditModal from '@/Components/PageComponents/Edit';

declare var route

const Show = ({
    configs,
    item,
    viewCallbacks,
    formCallbacks,
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
        title={`${TITLE} - ${TITLE_SHOW}「id: ${item.id}」`}
        className={`${CLASS_NAME} show`}
    >

        <section className='view show'>
            <header>
                <h1>{`${TITLE} - ${TITLE_SHOW}「id: ${item.id}」`}</h1>
                <div className='button-group'>
                    <EditModal
                        item={item}
                        configs={configs}
                        constants={constants}
                        formCallbacks={formCallbacks}
                    />
                    <DeleteButton
                        item={item}
                        constants={constants}
                    />
                    <OpenFormPreferenceSetting
                        config={configs.config}
                        preference={formPreference.preference}
                        setPreference={formPreference.storePreference}
                        deletePreference={formPreference.deletePreference}
                        item={item}
                    />
                </div>
            </header>
            <div className='content'>
                <Fields
                    config={configs.onfig}
                    data={item}
                    preference={formPreference.preference}
                    callbacks={viewCallbacks}
                />
            </div>
        </section>

    </Layout>)
}
export default Show
