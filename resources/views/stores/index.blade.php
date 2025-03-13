@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-3">ادارة المخازن</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- نموذج إضافة مخزن جديد -->
        <h3 class="mt-4">اضافة مخزن جديد</h3>
        <form action="{{ route('stores.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">اسم المخزن</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">العنوان</label>
                <input type="text" class="form-control" name="location" required>
            </div>
            <button type="submit" class="btn btn-primary">اضافة مخزن</button>
        </form>

        <!-- عرض قائمة المخازن -->
        <h2 class="mt-5">قائمة المخازن</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>اسم المخزن</th>
                    <th>العنوان</th>
                    <th>التفاصيل</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stores as $store)
                    <tr>
                        <td>{{ $store->name }}</td>
                        <td>{{ $store->location }}</td>
                        <td>
                            <a href="{{ route('stores.show', $store->id) }}" class="btn btn-info">اظهار التفاصيل</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
