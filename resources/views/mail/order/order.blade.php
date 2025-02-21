@extends('mail.layout')

@section('content')

<p>
    新規発注が届きました。<br />
    内容を確認してください。
</p>

<dl>
    <dt>発注番号</dt>
    <dd>{{ $mailParam['order']->code }}</dd>
    <dt>発注日時</dt>
    <dd>{{ date('Y-m-d H:i:s', strtotime($mailParam['ordered_at'])) }}</dd>
    <dt>希望納期</dt>
    <dd>{{ strtotime($mailParam['order']->deadline_at) ? date('Y-m-d', strtotime($mailParam['order']->deadline_at)) : 'なし' }}</dd>
    <dt>内容</dt>
    <dd>
        @include('mail.order.parts.detail_table', ['details' => $mailParam['detail']])
    </dd>
</dl>

<a class="button" href="{{ route('supplier.dashboard') }}">確認する&nbsp;&raquo;</a>

@endsection