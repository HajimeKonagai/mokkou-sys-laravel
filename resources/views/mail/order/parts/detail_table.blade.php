<table>
    <thead>
        <tr>
            <th>材料コード</th>
            <th>材料名</th>
            <th>単価</th>
            <th>数量</th>
            <th>単位</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($details as $detail)
        <tr>
            <td>{{ $detail->code }}</td>
            <td>{{ $detail->name }}</td>
            <td>{{ $detail->price }}</td>
            <td>{{ $detail->quantity }}</td>
            <td>{{ $detail->price }}</td>
        </tr>
        @endforeach
    </tbody>
</table>