import Layout from '@/Layouts/AdminLayout'
import Fields from "blu/Components/Form/Fields"
import { defaultDataFromConfig } from "blu/classes/model"
import { PreferenceApi, PreferenceLocalStorage } from 'blu/Components/Preference/Save'
import useForm, { toastErrors } from "blu/Laravel/classes/useForm"
import confirmBeforeUnload from 'blu/Laravel/classes/confirmBeforeUnload'
import { OpenFormPreferenceSetting } from 'blu/Components/Preference/Setting'
import { useModalContext } from 'blu/ContextComponents/Modal'
import { useQueryClient } from 'react-query'
import { Link } from '@inertiajs/react'
import { Edit } from './Edit'
import { useEffect } from 'react'

declare var route

const Create = ({
    configs,
    constants,
    createCallbacks,
    editCallbacks,
}) =>
{
    const { openModal, setPreventClose } = useModalContext()
    const {STORE_ROUTE, FORM_PREFERENCE_KEY, LABEL_STORE,
        TITLE, TITLE_EDIT, CLASS_NAME
    } = constants

    const queryClient = useQueryClient()
    const item = defaultDataFromConfig(configs.config)
    const { data, setData, errors, post, processing, isDirty } = useForm(item)
    confirmBeforeUnload(isDirty)

    useEffect(() =>
    {
        setPreventClose(isDirty ? 'ウィンドウを閉じてもよろしいですか？\n※編集中のものは保存されません' : null)
    }, [ isDirty ])

    const create = (e) =>
    {
        e.preventDefault();

        post(route(STORE_ROUTE), {
            onSuccess: (res) =>
            {
                console.log('res', res, res.props.createdId)
                queryClient.invalidateQueries()
                // open edit
                openModal({
                    title: `${TITLE} - ${TITLE_EDIT}「id: ${res.props.createdId}」`,
                    content: <Edit
                        itemId={res.props.createdId}
                        configs={configs}
                        constants={constants}
                        editCallbacks={editCallbacks}
                    />,
                    className: `${CLASS_NAME} edit`,
                    preventCloseCallback: () => {
                        if (!confirm('ウィンドウを閉じてもよろしいですか？\n※編集中のものは保存されません')) return true
                        return false
                    },
                    isCleanUp: false
                })
            },
            onError: (err) =>
            {
                toastErrors(err)
            },

            preserveState: true,
            preserveScroll: true,
            async: true,
        });
    }

    // const formPreference = PreferenceApi({
    //     apiUrl: route('api.preference.get', {key: FORM_PREFERENCE_KEY}),
    const formPreference = PreferenceLocalStorage({
        storageKey: FORM_PREFERENCE_KEY,
        defaultPreference: configs.form
    })


    return (<>
        <section className='form create'>
            <header>
                <span></span>
                <OpenFormPreferenceSetting
                    config={configs.config}
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
                    config={configs.config}
                    data={data}
                    setData={setData}
                    preference={formPreference.preference}
                    errors={errors}
                    callbacks={createCallbacks}
                />
            </div>
            <footer className=''>
                <button className='button primary' disabled={processing} type='submit' onClick={create}>{LABEL_STORE}</button>
            </footer>
        </section>
    </>)
}

const CreateModal = ({
    configs,
    constants,
    createCallbacks,
    editCallbacks,
}) =>
{
    const { TITLE, TITLE_CREATE, CLASS_NAME } = constants
    const { openModal, closeModal } = useModalContext()

    return (<button
        className='button primary'
        onClick={() =>
        {
            openModal({
                title: `${TITLE} - ${TITLE_CREATE}`,
                content: <Create
                    configs={configs}
                    constants={constants}
                    createCallbacks={createCallbacks}
                    editCallbacks={editCallbacks}
                />,
                className: `${CLASS_NAME} create`,
                preventCloseCallback: () => {
                    if (!confirm('ウィンドウを閉じてもよろしいですか？\n※編集中のものは保存されません')) return true
                    return false
                },
                isCleanUp: false
            })
        }}
    >新規作成</button>)
}

export default CreateModal
