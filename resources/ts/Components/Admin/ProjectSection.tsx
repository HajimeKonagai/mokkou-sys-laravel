import { Link, usePage } from "@inertiajs/react"
import TextSnippetIcon from '@mui/icons-material/TextSnippet';
import { useIndexModal } from "../Reference/Components/IndexModal";
import { projectConstants } from "../constantas";
import axios from "axios";
import { useQueryClient } from "react-query";
import Fields from "blu/Components/View/Fields";
import { PreferenceLocalStorage } from "blu/Components/Preference/Save";
import { OpenFormPreferenceSetting } from "blu/Components/Preference/Setting";
import EditModal from "../PageComponents/Edit";

const ProjectSection = ({

}) =>
{
    const { props } = usePage()
    const { project, projectConfigs } = props
    const {FORM_PREFERENCE_KEY} = projectConstants

    // const formPreference = PreferenceApi({
    //     apiUrl: route('api.preference.get', {key: FORM_PREFERENCE_KEY}),
    const formPreference = PreferenceLocalStorage({
        storageKey: FORM_PREFERENCE_KEY,
        defaultPreference: projectConfigs.form
    })

    return (<section className="">
        <header>
            <ProjectButton
                buttonClass="button outline flex aitem-center"
            />
            <div className='button-group'>
                <EditModal
                    item={project}
                    configs={projectConfigs}
                    constants={projectConstants}
                    editCallbacks={{}}
                />
                <OpenFormPreferenceSetting
                    config={projectConfigs.config}
                    preference={formPreference.preference}
                    setPreference={formPreference.storePreference}
                    deletePreference={formPreference.deletePreference}
                    item={project}
                />
            </div>
        </header>
        <div className="content">
        {project && (<>
            <Fields
                config={projectConfigs.config}
                data={project}
                preference={formPreference.preference}
                callbacks={{}}
            />
        </>)}
        </div>
    </section>)
}

declare var route

const ProjectButton = ({
    buttonClass='button outline white flex aitem-center'
}) =>
{
    const { props } = usePage()
    const { project, projectConfigs } = props

    const queryClient = useQueryClient()

    const customCells = {
        '_control': {
            type: ({ data }) => {
                return (<Link
                    className="button primary small"
                    href={route('admin.session.put_project', {project: data.id})}
                    method="put"
                    onFinish={() => {
                        closeModal()
                        queryClient.invalidateQueries()
                    }}
                    replace={true}
                >
                    選択
                </Link>)
            },
            props: {
            },
            label: '選択'
        }
    }

    const {openModal, closeModal, component: modalComponent} = useIndexModal({
        apiUrl: route('admin.project'),
        referenceConfigs: projectConfigs,
        index_preference_key: projectConstants.INDEX_PREFERENCE_KEY,
        search_preference_key: projectConstants.SEARCH_PREFERENCE_KEY,
        customCells: customCells,
        title: '現場選択',
    })

    return (<>
        <div className="flex justify-center flex-col items-stretch button-group">
            <button className={buttonClass} onClick={() => openModal()}>
            {project && (<>
                <TextSnippetIcon />
                <span className="whitespace-normal">{project.name}</span>
            </>) || (<>
                現場を選択
            </>)}
            </button>

        </div>
        {modalComponent}
    </>)

}

export {
    ProjectButton
}

export default ProjectSection