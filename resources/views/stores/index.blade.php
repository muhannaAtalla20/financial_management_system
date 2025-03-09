@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-3">Store Management</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- نموذج إضافة مخزن جديد -->
        <h3 class="mt-4">Add New Store</h3>
        <form action="{{ route('stores.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Store Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Address</label>
                <input type="text" class="form-control" name="location" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Store</button>
        </form>

        <!-- عرض قائمة المخازن -->
        <h2 class="mt-5">List Stores</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Store Name</th>
                    <th>Address</th>
                    <th>The Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stores as $store)
                    <tr>
                        <td>{{ $store->name }}</td>
                        <td>{{ $store->location }}</td>
                        <td>
                            <a href="{{ route('stores.show', $store->id) }}" class="btn btn-info">Show Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
