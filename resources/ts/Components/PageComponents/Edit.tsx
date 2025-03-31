import Layout from '@/Layouts/AdminLayout'
import Fields from "blu/Components/Form/Fields"
import { defaultDataFromConfig } from "blu/classes/model"
import { PreferenceApi, PreferenceLocalStorage } from 'blu/Components/Preference/Save'
import useForm, { toastErrors } from "blu/Laravel/classes/useForm"
import confirmBeforeUnload from 'blu/Laravel/classes/confirmBeforeUnload'
import { OpenFormPreferenceSetting } from 'blu/Components/Preference/Setting'
import { useModalContext } from 'blu/ContextComponents/Modal'
import { useQueryClient } from 'react-query'
import EditIcon from '@mui/icons-material/ModeEdit';
import { useView } from 'blu/classes/apis'
import { useEffect } from 'react'

declare var route

const EditForm = ({
    item,
    configs,
    constants,
    editCallbacks,
}) =>
{
    const { openModal, setPreventClose } = useModalContext()
    const {UPDATE_ROUTE, FORM_PREFERENCE_KEY, TITLE, TITLE_EDIT, LABEL_UPDATE, CLASS_NAME} = constants
    const queryClient = useQueryClient()
    const { data, setData, errors, put, processing, isDirty } = useForm(item)
    confirmBeforeUnload(isDirty)
    useEffect(() =>
    {
        setPreventClose(isDirty ? 'ウィンドウを閉じてもよろしいですか？\n※編集中のものは保存されません' : null)
    }, [ isDirty ])

    const update = (e) =>
    {
        e.preventDefault();

        put(route(UPDATE_ROUTE, { id: item.id }),
        {
            onSuccess: (res) =>
            {
                queryClient.invalidateQueries()
                openModal({
                    title: `${TITLE} - ${TITLE_EDIT}「id: ${item.id}」`,
                    content: <Edit
                        itemId={item.id}
                        configs={configs}
                        constants={constants}
                        editCallbacks={editCallbacks}
                    />,
                    className: `${CLASS_NAME} edit`,
                    isCleanUp: false
                })
            },
            onError: (err) =>
            {
                toastErrors(err)
            }
        });
    };


    // const formPreference = PreferenceApi({
    //     apiUrl: route('api.preference.get', {key: FORM_PREFERENCE_KEY}),
    const formPreference = PreferenceLocalStorage({
        storageKey: FORM_PREFERENCE_KEY,
        defaultPreference: configs.form
    })


    return (<>
        <section className='form edit'>
            <header>
                <h1>
                    {`${TITLE} - ${TITLE_EDIT}「id: ${item.id}」`}
                </h1>
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
                    callbacks={editCallbacks}
                />
            </div>
            <footer className=''>
                <button className='button primary' disabled={processing} type='submit' onClick={update}>{LABEL_UPDATE}</button>
            </footer>
        </section>
    </>)
}

const Edit = ({
    itemId,
    configs,
    constants,
    editCallbacks,
}) =>
{
    const { isLoading, data: item } = useView(route(constants.SHOW_ROUTE, {id: itemId}))

    return <>
        {isLoading && (<>
            Loading
        </>) || (
            <EditForm
                item={item}
                configs={configs}
                constants={constants}
                editCallbacks={editCallbacks}
            />
        )}
    </>
}

const EditModal = ({
    item,
    configs,
    constants,
    editCallbacks
}) =>
{
    const { TITLE, TITLE_EDIT, CONTROL_EDIT_LABEL, CLASS_NAME } = constants

    const { openModal, closeModal } = useModalContext()

    return (<button
        className='small button edit' 
        onClick={() =>
        {
            openModal({
                title: `${TITLE} - ${TITLE_EDIT}「id: ${item.id}」`,
                content: <Edit
                    itemId={item.id}
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
        }}
    ><EditIcon />{CONTROL_EDIT_LABEL}</button>)
}

export default EditModal
export {
    Edit
}
