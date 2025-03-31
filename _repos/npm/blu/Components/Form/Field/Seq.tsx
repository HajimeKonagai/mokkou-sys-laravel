import { FieldInputFormProps } from '../../types/Field'

const Seq = ({
    name,
    fieldConfig,
    fieldData,
}: FieldInputFormProps) =>
{
    return (<input
        name={name}
        className={`Seq ${fieldConfig.className ?? ''}`}
        type='number'
        value={fieldData ?? 0}
        readOnly={true}
        disabled={fieldConfig.disabled ? true :false}

        size={fieldConfig.size ?? null}
        min={fieldConfig.min ?? 0}
        max={fieldConfig.max ?? 9999}
    />)
}

export default Seq