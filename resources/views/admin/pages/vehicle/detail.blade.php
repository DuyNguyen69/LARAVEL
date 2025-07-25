@extends('admin.layout.admin')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <h2 class="page-title">VEHICLE INFORMATION</h2>
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <strong class="card-title">VEHICLE INFORMATION</strong>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.vehicle.update', ['car' => $data->id]) }}"
                                enctype="multipart/form-data" id="form-vehicle-store">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                value="{{ $data->name }}">
                                        </div>
                                        @error('name')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group mb-3">
                                            <label for="brand">Brand</label>
                                            <input type="text" id="brand" name="brand" class="form-control"
                                                placeholder="Brand" value="{{ $data->brand }}">
                                        </div>
                                        @error('brand')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="input-group mb-3">
                                            <input type="text" id="price_per_day" name="price_per_day"
                                                class="form-control" placeholder="Giá / ngày"
                                                value="{{ old('price_per_day', number_format((int) $data->price_per_day)) }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">₫</span>
                                            </div>
                                        </div>

                                        @error('price_per_day')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="card shadow">
                                            <div class="card-body">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" hidden>{{ $data->description }}</textarea>
                                                <div id="description_quill" style="min-height: 200px;">
                                                    {!! $data->description !!}</div>
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
                                            @if (!empty($data->image))
                                                <div class="mt-2">
                                                    <p>Current image:</p>
                                                    <img src="{{ asset($data->image) }}" alt="Current image" width="500">
                                                </div>
                                            @endif
                                        </div>
                                        @error('image')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="form-group">
                                            <div class="form-group mb-3">
                                                <label for="status">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="available"
                                                        {{ $data->status == 'available' ? 'selected' : '' }}>Available
                                                    </option>
                                                    <option value="rented"
                                                        {{ $data->status == 'rented' ? 'selected' : '' }}>Rented</option>
                                                    <option value="maintenance"
                                                        {{ $data->status == 'maintenance' ? 'selected' : '' }}>Maintenance
                                                    </option>
                                                </select>
                                            </div>
                                            @error('status')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                            <div class="form-group mb-3">
                                                <label for="category_id">Vehicle Type</label>
                                                <select name="category_id" class="form-control">
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ old('category_id', $data->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->id }}. {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('category_id')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-outline-secondary">Update</button>
                                        <button type="button" class="btn btn-outline-secondary"   id="btn-reset-form">Restore</button>
                                        <a href="{{ route('admin.vehicle.index') }}" type="button" class="btn btn-outline-secondary" id="">Back to list</a>
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

            function formatNumber(value) {
                return value.replace(/\D/g, '')
                    .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            input.addEventListener('input', () => {
                let cursorPos = input.selectionStart;
                let rawValue = input.value.replace(/\D/g, '');
                let formatted = formatNumber(rawValue);

                input.value = formatted;

                // Giữ lại vị trí con trỏ khi người dùng gõ
                input.setSelectionRange(cursorPos, cursorPos);
            });

            // Trước khi submit form, bỏ dấu . đi
            input.form.addEventListener('submit', () => {
                input.value = input.value.replace(/\D/g, '');
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("form-vehicle-store");

            // Lưu dữ liệu ban đầu
            const originalValues = {};
            Array.from(form.elements).forEach(el => {
                if (el.name && (el.type !== "file" && el.type !== "hidden")) {
                    originalValues[el.name] = el.value;
                }
            });

            // Khôi phục khi bấm nút
            document.getElementById("btn-reset-form").addEventListener("click", () => {
                Array.from(form.elements).forEach(el => {
                    if (el.name && originalValues.hasOwnProperty(el.name)) {
                        el.value = originalValues[el.name];
                    }
                });

                // Nếu bạn dùng Quill cho mô tả
                if (typeof quill !== 'undefined' && originalValues['description']) {
                    quill.root.innerHTML = originalValues['description'];
                }
            });
        });
    </script>
@endsection
