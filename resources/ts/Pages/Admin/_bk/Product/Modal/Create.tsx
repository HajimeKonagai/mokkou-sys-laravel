import Layout from '@/Layouts/AdminLayout'
import Fields from "blu/Components/Form/Fields"
import { defaultDataFromConfig } from "blu/classes/model"
import { PreferenceApi, PreferenceLocalStorage } from 'blu/Components/Preference/Save'
import useForm, { toastErrors } from "blu/Laravel/classes/useForm"
import confirmBeforeUnload from 'blu/Laravel/classes/confirmBeforeUnload'
import { OpenFormPreferenceSetting } from 'blu/Components/Preference/Setting'
import {
    TITLE,
    FORM_PREFERENCE_KEY,
    STORE_ROUTE,
    CLASS_NAME,
    TITLE_CREATE,
    LABEL_STORE,

} from '../constants'
import customCallbacks from '../Form/customCallbacks'
import { useModalContext } from 'blu/ContextComponents/Modal'
import { useEffect, useState } from 'react'
import { useQueryClient } from 'react-query'

declare var route

const Create = ({
    config,
    formConfig=['*'],
    formCallbacks,
}) =>
{
    const queryClient = useQueryClient()
    const item = defaultDataFromConfig(config)
    const { data, setData, errors, post, processing, isDirty } = useForm(item)
    confirmBeforeUnload(isDirty)

    const create = (e) =>
    {
        e.preventDefault();

        post(route(STORE_ROUTE), {
            onSuccess: (res) =>
            {
                queryClient.invalidateQueries()
                // console.log('onSuccess', res)
            },
            onError: (err) =>
            {
                toastErrors(err)
            },
        });
    }

    // const formPreference = PreferenceApi({
    //     apiUrl: route('api.preference.get', {key: FORM_PREFERENCE_KEY}),
    const formPreference = PreferenceLocalStorage({
        storageKey: FORM_PREFERENCE_KEY,
        defaultPreference: formConfig
    })


    return (<>

        <section className='form create'>
            <header>
                <span></span>
                <OpenFormPreferenceSetting
                    config={config}
                    preference={formPreference.preference}
                    setPreference={formPreference.storePreference}
                    deletePreference={formPreference.deletePreference}
                    item={item}
                    data={data}
                    setData={setData}
                />
            </header>
            <div className="content">
                <Fields
                    config={config}
                    data={data}
                    setData={setData}
                    preference={formPreference.preference}
                    errors={errors}
                    callbacks={formCallbacks}
                />
            </div>
            <footer className=''>
                <button className='button primary' disabled={processing} type='submit' onClick={create}>{LABEL_STORE}</button>
            </footer>
        </section>
    </>)
}

const ModalCreate = ({
    config,
    formCallbacks
}) =>
{
    const { openModal, closeModal } = useModalContext()

    return (<button
        className='button primary'
        onClick={() =>
        {
            openModal({
                title: '新規作成',
                content: <Create
                    config={config}
                    formConfig={['*']}
                    formCallbacks={formCallbacks}
                />,
                className: 'create-modal',
                preventCloseCallback: () => {
                    if (!confirm('ウィンドウを閉じてもよろしいですか？\n※編集中のものは保存されません')) return true
                    return false
                },
            })
        }}
    >新規作成</button>)
}

export default ModalCreate
