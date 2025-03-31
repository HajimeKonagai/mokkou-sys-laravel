import { useModalContext } from "blu/ContextComponents/Modal"
import { PreferenceApi, PreferenceLocalStorage } from 'blu/Components/Preference/Save'
import useForm, { toastErrors } from "blu/Laravel/classes/useForm"
import { OpenFormPreferenceSetting } from "blu/Components/Preference/Setting"
import Fields from "blu/Components/View/Fields"
import ShowIcon from '@mui/icons-material/Visibility';
import EditModal from "./Edit"
import DeleteButton from "./Delete"
import { useView } from "blu/classes/apis"

declare var route

const Show = ({
    item,
    configs,
    constants,
    showCallbacks,
    editCallbacks,
}) =>
{
    const {
        FORM_PREFERENCE_KEY,
        EDIT_ROUTE, CONTROL_EDIT_LABEL, CONTROL_DELETE_LABEL, DELETE_ROUTE, DELETE_MESSAGE,
        TITLE, TITLE_SHOW
    } = constants

    const { isLoading, data } = useView(route(constants.SHOW_ROUTE, {id: item.id}))


    // const formPreference = PreferenceApi({
    //     apiUrl: route('api.preference.get', {key: FORM_PREFERENCE_KEY}),
    const formPreference = PreferenceLocalStorage({
        storageKey: FORM_PREFERENCE_KEY,
        defaultPreference: configs.form
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

    return (<section className='view show'>
        {isLoading && (<>loading...</>) || (<>
            <header>
                <h1>{`${TITLE} - ${TITLE_SHOW}「id: ${data.id}」`}</h1>
                <div className='button-group'>
                    <EditModal
                        item={data}
                        configs={configs}
                        constants={constants}
                        editCallbacks={editCallbacks}
                    />
                    <DeleteButton
                        item={data}
                        constants={constants}
                    />
                    <OpenFormPreferenceSetting
                        config={configs.config}
                        preference={formPreference.preference}
                        setPreference={formPreference.storePreference}
                        deletePreference={formPreference.deletePreference}
                        item={data}
                    />
                </div>
            </header>
            <div className='content'>
                <Fields
                    config={configs.config}
                    data={data}
                    preference={formPreference.preference}
                    callbacks={showCallbacks}
                />
            </div>
        </>)}
    </section>)

}

const ShowModal = ({
    item,
    configs,
    constants,
    showCallbacks,
    editCallbacks
}) =>
{
    const { TITLE, TITLE_SHOW, CLASS_NAME } = constants
    const { openModal } = useModalContext()


    return (<button
        className='small button view'
        onClick={() =>
        {
            openModal({
                title: `${TITLE} - ${TITLE_SHOW}「id: ${item.id}」`,
                content: <Show
                    item={item}
                    configs={configs}
                    constants={constants}
                    showCallbacks={showCallbacks}
                    editCallbacks={editCallbacks}
                />,
                className: `${CLASS_NAME} show`,
            })
        }}
    ><ShowIcon />表示</button>)

}

export default ShowModal