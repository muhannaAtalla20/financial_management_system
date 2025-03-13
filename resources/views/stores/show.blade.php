@extends('layouts.app')

@section('content')
    <div class="container" dir="rtl">
        <h1>تفاصيل المخزن - {{ $store->name }}</h1>
        <p><strong>العنوان : </strong> {{ $store->location }}</p>

        <!-- نموذج إضافة تصنيف جديد -->
        <h3>إضافة فئة جديدة</h3>
        <form action="{{ route('stores.addCategory', $store->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="category_name" class="form-label">اسم الفئة</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">اضافة فئة</button>
        </form>

        <!-- نموذج إضافة تبرعات -->
        <h3 class="mt-4">اضافة تبرع</h3>
        <form action="{{ route('stores.addDonation', $store->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="category_name" class="form-label">اختار فئة</label>
                <select class="form-control" name="category_name" required>
                    @foreach ($store->categories as $category)
                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="carton_quantity" class="form-label">عدد الكراتين</label>
                <input type="number" class="form-control" name="carton_quantity" required>
            </div>
            <div class="mb-3">
                <label for="item_quantity" class="form-label">عدد العناصر</label>
                <input type="number" class="form-control" name="item_quantity" required>
            </div>
            <div class="mb-3">
                <label for="source" class="form-label">المصدر</label>
                <input type="text" class="form-control" name="source" required>
            </div>
            <button type="submit" class="btn btn-success">اضافة تبرع</button>
        </form>

        <!-- عرض التبرعات المخزنة -->
        <h2 class="mt-5">التبرعات داخل المستودع</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>تصنيف</th>
                    <th>عدد الكراتين</th>
                    <th>عدد العناصر</th>
                    <th>المصدر</th>
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

        <a href="{{ route('stores.index') }}" class="btn btn-secondary" style="margin-bottom: 25px">العودة الى المخازن</a>
    </div>
@endsection
