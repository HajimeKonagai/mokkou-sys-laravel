import AdminLayout from '@/Layouts/AdminLayout'
import axios from 'axios'
import { useQuery, useMutation, useQueryClient } from 'react-query'
import { useEffect, useState, useRef } from "react"


import DataTable from 'blu-csv/Components/DataTable'
import { useSetting } from 'blu-csv/Components/Setting'
import { useCsvReader } from 'blu-csv/Components/CsvReader'
import SearchField  from 'blu-csv/Components/SearchField'
import ImportFields  from 'blu-csv/Components/ImportFields'

import Encoding from 'encoding-japanese'


import 'blu-csv/sass/blu-csv.scss'
import { useStore } from 'blu/classes/apis'
import { PreferenceApi } from 'blu/Components/Preference/Save'
import { is_json } from 'blu/classes/util'

const encode = (value, encoding) =>
{
    return Encoding.convert(value, {to: 'UNICODE', from: encoding})
}

const valReplace = (value, replace) =>
{
    let newValue = value.toString();
    replace.map((rep) => {
        newValue = newValue.replaceAll(rep.from, rep.to);
    });

    return newValue;
}


declare var route


const ImportResultComponent = ({ result }) =>
{
    return (<div className="ImportResultComponent">
        {result && (
            <>
            {result.map((result) => (
                <div className={result.key}>
                <ul>
                {result.results.map((item) => (
                    <li className={item[0]}>{item[1]}</li>
                ))}
                </ul>
                </div>
            ))}
            </>
        ) || (
            <span style={{ color: 'gray'}}>no result</span>
        )}
	</div>)
}

const Import = ({
    auth,
    uniqid,
    customSetting,
    toFields,
}) =>
{
    const isFirstRender = useRef(true)

    const [ live, setLive ] = useState(false)
    const [ importRunning, setImportRunning ] = useState(false)
    const [ importResult, setImportResult ] = useState({});

    const { fileName, csvData, fromFields, importTargets, setImportTargets, tableComponent: CsvReader } = useCsvReader()

    useEffect(() => {
		if (live) setImportRunning(true);
	}, [live]);

	useEffect(() => {
		if (importRunning)
        {
            runImport()
        }
        else
        {
            setLive(false)
        }
	}, [importRunning]);

	useEffect(() => {
		if (importRunning)
        {

            const timer = setTimeout(() =>
            {
                runImport();
            }, 100)
    
            return () => clearTimeout(timer)


        }
	}, [importResult]);


    const importQuery = useMutation(
        async (params) =>
        {
            const { data } = await axios.post(
                route('api.admin.csv.import', {uniqid: uniqid}),
                params
            );

            return data;
        },
        {
            onSuccess: (results) =>
            {
                const key = live ? 'live': 'test';
                const newImportTargets = {...importTargets};
                const newResult = {...importResult};
    
                console.log('DataTableMedia onSuccess', results);
                for (let index in results)
                {
                    if (live)
                    {
                        delete newImportTargets[index];
                    }
                    else
                    {
                        newImportTargets[index].dry = true;
                    }
                    if (!newResult[index]) newResult[index] = [];
                    newResult[index].push({
                        key: key,
                        results: results[index],
                    });
                }
    
                setImportTargets(newImportTargets);
                setImportResult(newResult);

            },
            onError: () =>
            {
            },
        }
    )

    const runImport = () => 
    {
        if (!importRunning) return;

        // const postData = Object.keys(importTargets).slice(0, 5); // 5つ
		const postData = Object.keys(importTargets)
			.filter(key => {
				if (!live)
				{
					return !importTargets[key].dry;
				}
				else
				{
					return true;
				}
			})
			.slice(0, 10); // 5つ

        if (postData.length <= 0)
        {
            setImportRunning(false);
            return;
        }

        console.log('run import')

        // let params = {};
        const params = new FormData();
        params.append('file_name', fileName)

        if (live) params.append('live', '1')
        // additional setting values
        Object.keys(customSetting).map((key) => {
            console.log('key', key, setting[key])
            if (key in setting) params.append(key, setting[key])
        })

        
        postData.map((key) =>
        {
            let post = {};
            const item = csvData[key];
            if (setting.importFields)
            {
                setting.importFields.map((importField) =>
                {
                    // if (item[importField.from])
                    const value = valReplace(
                        encode(item[importField.from], setting.encoding),
                        importField.replace
                    );

                    params.append('posts[' + key + '][fields][' + importField.to + ']', value);
                });
            }
        });

        console.log(params);

        importQuery.mutate(params);

        return;
    }


    const loadPreference = PreferenceApi({
        apiUrl: route('api.admin.setting.get', {key: 'blu.csv_import'}),
    // const indexPreference = PreferenceLocalStorage({
        storageKey: 'blu.csv_import',
        defaultPreference: []
    })

    const { setting, setSetting, tableComponent: settingComponent } = useSetting({
        settings: loadPreference.preference ? loadPreference.preference : [],
        setSettings: (newSettings) =>
        {
            loadPreference.storePreference(newSettings)
        },
        resetSettings: () => {
            console.log('all delete')
            loadPreference.deletePreference()
        },
        customSetting: customSetting
    });

    useEffect(() =>
    {
        setImportResult({});
    }, [csvData])
    

    return (<AdminLayout
        auth={auth}
        title='Csv Import'
    >

        <section>
            <header>
                <h2>Setting</h2>
            </header>
            <div className="content">
                {settingComponent}
            </div>
        </section>

        <section>
            <header>
                <h2>Import Fields</h2>
            </header>
            <div className="content">
                <ImportFields
                    fromFields={fromFields}
                    toFields={toFields}
                    setting={setting}
                    setSetting={setSetting}
                />

                <p className="text-slate-800 text-sm mt-2">
                    ※「ファイルの〜から」において「【学名辞書】〜」には「科名(英)」〜「種名(和)」と同じカラムを指定できますが、その場合エクスポート時に上書きされてしまいます。<br />
                    エクスポート時に両方表示させたい場合は、お手数ですが「【学名辞書】〜」専用のカラムを追加した csv ファイルを読み込んで設定してください。
                </p>
            </div>

        </section>

        <section>
            <header>
                <h2>Csv File</h2>
            </header>
            <div className="content">
                {CsvReader}
            </div>
        </section>

        <section>
            <header>
                <h2>Csv Data</h2>
                <div>
                    {!importRunning &&
                        <div className="button-group">
                            <button className="button primary outline" onClick={() => setImportRunning(true)}>テストする</button>
                            <button className="button primary" onClick={() => setLive(true)}>インポート</button>
                        </div>
                    }
                    {importRunning &&
                        <>
                        <button
                            className="button warn"
                            onClick={() => {
                                setImportRunning(false);
                                setLive(false);
                            }}>
                                キャンセル
                            </button>
                            残り{Object.keys(importTargets).length}
                        </>
                    }
                </div>

            </header>
            <div className="content">
                <DataTable
                    csvData={csvData}
                    setting={setting}
                    toFields={toFields}
                    importFields={setting.importFields}
                    importTargets={importTargets}
                    setImportTargets={setImportTargets}
                    importResult={importResult}
                    setImportResult={setImportResult}
                    ResultComponent={ImportResultComponent}
                />
            </div>
        </section>


    </AdminLayout>)
}
export default Import
