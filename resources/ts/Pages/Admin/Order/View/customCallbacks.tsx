const customCallbacks = ({
}) =>
{
    return {
        'deadline': () => {
            return (<div>sampleCallback</div>)
        }
    }
}

export default customCallbacks