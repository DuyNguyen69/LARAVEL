@extends('admin.layout.admin')

@section('content')
    <div class="container mt-5">
        <h3>Rental Payment - #{{ $rental->id }}</h3>
        <div class="card shadow mt-4">
            <div class="card-body row g-4">
                <div class="col-md-7">
                    <h5>Rental Info</h5>
                    <p><strong>Customer:</strong> {{ $rental->user->name }} ({{ $rental->user->email }})</p>
                    <p><strong>Car:</strong> {{ $rental->vehicle->name }}</p>
                    <p><strong>Pickup:</strong> {{ $rental->start_date }} {{ $rental->pickup_time }}</p>
                    <p><strong>Drop-off:</strong> {{ $rental->end_date }} {{ $rental->dropoff_time }}</p>
                    @if ($rental->pickup_location)
                        <p><strong>Address:</strong> {{ $rental->pickup_location }}</p>
                    @endif
                    <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($rental->status) }}</span></p>

                </div>

                <div class="col-md-5">
                    <h5>Payment</h5>
                    @if ($rental->status !== 'completed')
                        <form method="POST" action="{{ route('admin.rentals.markAsPaid', $rental) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary">Payment</button>

                            <!-- Hiển thị tiền -->
                            @if ($rental->dropoff_time)
                                <p class="mt-3">
                                    <strong>Total:</strong>
                                    {{ number_format($rental->calculateTotal(), 0, ',', '.') }}₫
                                </p>
                            @endif
                        </form>
                    @else
                        <div class="alert alert-success mt-3">Rental has been paid.</div>
                    @endif
                </div>
            </div>
        </div>

        <a href="{{ route('admin.rentals.index') }}" class="btn btn-link mt-3">← Back to Rentals</a>
    </div>
@endsection

