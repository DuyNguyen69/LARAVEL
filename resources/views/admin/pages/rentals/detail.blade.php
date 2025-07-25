@extends('admin.layout.admin')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">

            <h2 class="mb-4">Rental Details</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif (session('info'))
                <div class="alert alert-success">{{ session('info') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.rentals.update', $rental->id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                {{-- Customer Info --}}
                <div class="col-md-6">
                    <label class="form-label">Customer Name</label>
                    <input type="text" class="form-control" value="{{ $rental->user->name }}" disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Customer Email</label>
                    <input type="text" class="form-control" value="{{ $rental->user->email }}" disabled>
                </div>

                {{-- Vehicle Info --}}
                <div class="col-md-6">
                    <label class="form-label">Vehicle</label>
                    <input type="text" class="form-control" value="{{ $rental->vehicle->name ?? 'No vehicle' }}"
                        disabled>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Price per Day</label>
                    <input type="text" class="form-control"
                        value="{{ number_format($rental->vehicle->price_per_day ?? 0, 0, ',', '.') }}₫" disabled>
                </div>

                {{-- Dates & Times --}}
                <div class="col-md-6">
                    <label class="form-label">Pickup Date</label>
                    <input type="date" name="pickup_date" class="form-control"
                        value="{{ old('pickup_date',$rental->pickup_date) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pickup Time</label>
                    <input type="time" name="pickup_time" class="form-control"
                        value="{{ old('pickup_time', \Carbon\Carbon::parse($rental->pickup_time)->format('H:i')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Drop-off Date</label>
                    <input type="date" name="dropoff_date" class="form-control"
                        value="{{ old('dropoff_date',$rental->dropoff_date) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Drop-off Time</label>
                    <input type="time" name="dropoff_time" class="form-control"
                        value="{{ old('dropoff_time', \Carbon\Carbon::parse($rental->dropoff_time)->format('H:i')) }}">
                </div>

                {{-- Location --}}
                <div class="col-md-12">
                    <label class="form-label">Delivery Address (optional)</label>
                    <input type="text" name="delivery_address" class="form-control"
                        value="{{ old('delivery_address', $rental->delivery_address) }}">
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" disabled>
                        <option value="pending" {{ $rental->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $rental->status === 'confirmed' ? 'selected' : '' }}>Confirmed
                        </option>
                        <option value="completed" {{ $rental->status === 'completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="canceled" {{ $rental->status === 'canceled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                </div>

                {{-- Save Button --}}
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="{{ route('admin.rentals.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </form>
        </div>
    </main>


@endsection

@section('my-js')
    <script>
        flatpickr("input[name='pickup_date']", {
            minDate: "today",
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                const dropoff = document.querySelector("input[name='dropoff_date']");
                if (dropoff._flatpickr) {
                    dropoff._flatpickr.set('minDate', dateStr ? new Date(selectedDates[0].getTime() +
                        86400000) : "today");
                }
            }
        });

        flatpickr("input[name='dropoff_date']", {
            minDate: new Date().fp_incr(1),
            dateFormat: "Y-m-d"
        });
    </script>
@endsection
