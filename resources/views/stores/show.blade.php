@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Store Details - {{ $store->name }}</h1>
        <p><strong>Address : </strong> {{ $store->location }}</p>

        <!-- نموذج إضافة تصنيف جديد -->
        <h3>Add New Category</h3>
        <form action="{{ route('stores.addCategory', $store->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="category_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>

        <!-- نموذج إضافة تبرعات -->
        <h3 class="mt-4">Add Donations</h3>
        <form action="{{ route('stores.addDonation', $store->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="category_name" class="form-label">Select Category</label>
                <select class="form-control" name="category_name" required>
                    @foreach ($store->categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="carton_quantity" class="form-label">Number Of Cartons</label>
                <input type="number" class="form-control" name="carton_quantity" required>
            </div>
            <div class="mb-3">
                <label for="item_quantity" class="form-label">Number Of Items</label>
                <input type="number" class="form-control" name="item_quantity" required>
            </div>
            <div class="mb-3">
                <label for="source" class="form-label">Source</label>
                <input type="text" class="form-control" name="source" required>
            </div>
            <button type="submit" class="btn btn-success">Add Donation</button>
        </form>

        <!-- عرض التبرعات المخزنة -->
        <h2 class="mt-5">Donations inside the warehouse</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Classification</th>
                    <th>Number of cartons</th>
                    <th>Number of items</th>
                    <th>Source</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($store->donations as $donation)
                    <tr>
                        <td>{{ $donation->category->name }}</td>
                        <td>{{ $donation->carton_quantity }}</td>
                        <td>{{ $donation->item_quantity }}</td>
                        <td>{{ $donation->source }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('stores.index') }}" class="btn btn-secondary">Back to stores</a>
    </div>
@endsection
