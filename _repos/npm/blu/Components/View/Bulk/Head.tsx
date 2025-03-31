const Head = ({
    tag = 'table',
    config,
}) =>
{
    return (tag == 'table' && (
        <thead>
            <tr>
                {Object.keys(config).map((key) => (<>
                    {(config[key].type && config[key].type != 'hidden') && (
                        <th key={key}>
                            {config[key].label ?? key}
                        </th>
                    )}
                </>))}
            </tr>
        </thead>
    ) || (
        <></>
    ))
}

export default Head