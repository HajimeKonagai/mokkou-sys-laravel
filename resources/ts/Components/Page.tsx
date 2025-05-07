import { Link, useForm } from "@inertiajs/react"
import SearchFields from "blu/Components/Index/SearchFields"
import Table from "blu/Components/Index/Table"
import { OpenFormPreferenceSetting, OpenIndexPreferenceSetting, OpenSearchPreferenceSetting } from "blu/Components/Preference/Setting"
import { ViewContextProvider } from "blu/Components/View/Fields"
import { useModalContext } from "blu/ContextComponents/Modal"
import useSearch from "blu/Laravel/classes/useSearch"
import Pagination from "blu/Laravel/Pagination"
import { PreferenceApi, PreferenceLocalStorage } from 'blu/Components/Preference/Save'
import ShowModal from "./PageComponents/Show"
import CreateModal from "./PageComponents/Create"
import EditModal from "./PageComponents/Edit"
import DeleteButton from "./PageComponents/Delete"

declare var route

const Control = ({
    data,
    editConfigs,
    showConfigs,
    constants,
    editCallbacks,
    showCallbacks,
}) =>
{
    return (<div className='button-group'>
        <ShowModal
            item={data}
            configs={showConfigs}
            constants={constants}
            showCallbacks={showCallbacks}
            editCallbacks={editCallbacks}
        />
        <EditModal
            item={data}
            configs={editConfigs}
            constants={constants}
            editCallbacks={editCallbacks}
        />
        <DeleteButton
            item={data}
            constants={constants}
        />
    </div>)
}

const Page = ({
    configs,
    constants,

    createCallbacks = {},
    editCallbacks = {},
    showCallbacks = {},
    indexCallbacks = {},

    searchConfigs = null,
    indexConfigs = null,
    showConfigs = null,
    createConfigs = null,
    editConfigs = null,

    customCells = {},
    replaceState=true,
    forceCustomrCells=true,
}) =>
{
    const { TITLE, API_ROUTE, SEARCH_PREFERENCE_KEY, INDEX_PREFERENCE_KEY, CONTROL_NAME } = constants

    searchConfigs = searchConfigs ? searchConfigs : configs
    indexConfigs  = indexConfigs  ? indexConfigs  : configs
    showConfigs   = showConfigs   ? showConfigs   : configs
    createConfigs = createConfigs ? createConfigs : configs
    editConfigs   = editConfigs   ? editConfigs   : configs


    const { openModal, closeModal } = useModalContext()

    // const searchPreference = PreferenceApi({
    // apiUrl: route('api.preference.get', {key: SEARCH_PREFERENCE_KEY}),
    const searchPreference = PreferenceLocalStorage({
        storageKey: SEARCH_PREFERENCE_KEY,
        defaultPreference: searchConfigs.search
    })

    // const indexPreference = PreferenceApi({
        // apiUrl: route('api.preference.get', {key: INDEX_PREFERENCE_KEY}),
    const indexPreference = PreferenceLocalStorage({
        storageKey: INDEX_PREFERENCE_KEY,
        defaultPreference: indexConfigs.index
    })


    const { searchParams, setSearchParams, results } = useSearch({
        apiUrl: route(API_ROUTE),
        replaceState: replaceState,
    })

    customCells = {...{
        '_control': {
            type: Control,
            props: {
                editConfigs,
                showConfigs,
                constants,
                editCallbacks,
                showCallbacks,
            },
            label: CONTROL_NAME
        },
    }, ...customCells}
    

    const configForIndex = {...indexConfigs.config, ...customCells}
    if (forceCustomrCells)
    {
        Object.keys(customCells).map((key)=> {
            const newCustomCell = {...configForIndex[key]}
            newCustomCell.label = <>{('label' in configForIndex[key] ? configForIndex[key].label : key)}(*)</>
            configForIndex[key] = newCustomCell
        })
    }

    return (<>
        <section className='search'>
            <header>
                <h1>{TITLE} - 検索</h1>
                {(searchPreference && 'preference' in searchPreference) && (
                <OpenSearchPreferenceSetting
                    config={searchConfigs.config}
                    preference={searchPreference.preference}
                    setPreference={searchPreference.storePreference}
                    deletePreference={searchPreference.deletePreference}
                />)}
            </header>
            <div className="content">
                <SearchFields
                    config={searchConfigs.config}
                    data={searchParams}
                    setData={setSearchParams}
                    preference={searchPreference && 'preference' in searchPreference ?
                        searchPreference.preference :
                        Array.isArray(searchPreference) ? searchPreference : []
                    }
                />
            </div>
        </section>


        <section className='index'>
            <header>
                <h1>{TITLE} - 一覧</h1>
                {(indexPreference && 'preference' in indexPreference) && (
                <OpenIndexPreferenceSetting
                    config={configForIndex}
                    preference={indexPreference.preference}
                    setPreference={indexPreference.storePreference}
                    deletePreference={indexPreference.deletePreference}
                />)}
            </header>
            <header>
                <CreateModal
                    configs={createConfigs}
                    constants={constants}
                    createCallbacks={createCallbacks}
                    editCallbacks={editCallbacks}
                />
            </header>

            <div className='content'>
                <Pagination
                    data={results.data}
                    setSearchParams={setSearchParams}
                    isLoading={results.isLoading}
                />
                <ViewContextProvider
                    callbacks={indexCallbacks}
                >
                    <Table
                        config={configForIndex}
                        preference={indexPreference && 'preference' in indexPreference ?
                            indexPreference.preference :
                            Array.isArray(indexPreference) ? indexPreference : []
                        }
                        isLoading={results.isLoading}
                        data={results.data?.data}
                        searchParams={searchParams}
                        setSearchParams={setSearchParams}
                        customCells={customCells}
                        forceCustomrCells={forceCustomrCells}
                    />
                </ViewContextProvider>

                <Pagination
                    data={results.data}
                    setSearchParams={setSearchParams}
                    isLoading={results.isLoading}
                />
            </div>
            <footer style={{justifyContent: 'start'}}>
                <CreateModal
                    configs={createConfigs}
                    constants={constants}
                    createCallbacks={createCallbacks}
                    editCallbacks={editCallbacks}
                />
                <span></span>
            </footer>
        </section>
    </>)

}
export default Page

export {
    Control
}