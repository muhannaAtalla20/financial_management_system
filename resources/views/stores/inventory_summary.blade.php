@extends('layouts.app')

@section('content')
    <h1>ملخص المخزون - {{ $store->name }}</h1>

    <ul>
        @foreach ($summary as $data)
            <li>
                التصنيف: {{ $data['category'] }} | 
                إجمالي الكراتين: {{ $data['total_cartons'] }} | 
                إجمالي العناصر: {{ $data['total_items'] }}
            </li>
        @endforeach
    </ul>

    <a href="{{ route('stores.show', $store->id) }}">العودة إلى المخزن</a>
@endsection
