@extends('admin.layout.admin')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="page-title">CREATE VEHICLE FORM</h2>
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">Create Vehicle</strong>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.vehicle.store') }}" enctype="multipart/form-data"
                                id="form-vehicle-store">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                value="{{ old('name') }}">
                                        </div>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group mb-3">
                                            <label for="brand">Brand</label>
                                            <input type="text" id="brand" name="brand" class="form-control"
                                                placeholder="Brand" value="{{ old('brand') }}">
                                        </div>
                                        @error('brand')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group mb-3">
                                            <label for="price_per_day">Price per day</label>
                                            <input type="text" id="price_per_day" name="price_per_day"
                                                class="form-control" placeholder="Giá / ngày"
                                                value="{{ old('price_per_day') }}">
                                        </div>
                                        @error('price_per_day')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="card shadow">
                                            <div class="card-body">
                                                <label for="description">Description</label>

                                                {{-- Hidden textarea dùng để submit dữ liệu --}}
                                                <textarea name="description" id="description" hidden>{{ old('description') }}</textarea>

                                                {{-- Vùng hiển thị editor --}}
                                                <div id="description_quill" style="min-height: 200px;">
                                                    {!! old('description') !!}</div>
                                            </div>
                                        </div>
                                        @error('description')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="image">Image</label>
                                            <input type="file" name="image" class="form-control" accept="image/*">
                                        </div>
                                        @error('image')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <div class="form-group mb-3">
                                                <label for="status">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="available"
                                                        {{ old('status') == 'available' ? 'selected' : '' }}>Có sẵn
                                                    </option>
                                                    <option value="rented"
                                                        {{ old('status') == 'rented' ? 'selected' : '' }}>Đã thuê</option>
                                                    <option value="maintenance"
                                                        {{ old('status') == 'maintenance' ? 'selected' : '' }}>Đang sửa
                                                    </option>
                                                </select>
                                            </div>
                                            @error('status')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="form-group mb-3">
                                                <label for="category_id">Vehicle Type</label>
                                                <select name="category_id" id="category_id" class="form-control">
                                                    <option value="" disabled
                                                        {{ old('category_id') ? '' : 'selected' }}>
                                                        -- Vui lòng chọn dòng xe --
                                                    </option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->id }}. {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            @error('category_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">ADD CAR</button>
                                    </div>
                                </div>
                            </form>
                        </div> <!-- / .card -->
                    </div> <!-- .col-12 -->
                </div> <!-- .row -->
            </div> <!-- .container-fluid -->

    </main>
@endsection

@section('my-js')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        const quill = new Quill('#description_quill', {
            theme: 'snow'
        });
        const oldDescription = $('#description').val();
        if (oldDescription) {
            quill.root.innerHTML = oldDescription;
        }
        $("#form-vehicle-store").on("submit", function() {
            $("#description").val(quill.root.innerHTML);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('price_per_day');

            const formatVND = (val) => val ? new Intl.NumberFormat('vi-VN').format(val.replace(/\D/g, '')):
                '';

            input.addEventListener('input', e => input.value = formatVND(e.target.value));
            input.addEventListener('focus', e => input.value = e.target.value.replace(/\D/g, ''));
            input.addEventListener('blur', e => input.value = formatVND(e.target.value));
        });
    </script>
@endsection
