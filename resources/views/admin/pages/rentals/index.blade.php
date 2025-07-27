@extends('admin.layout.admin')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <h2 class="mb-4">Rental Management</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Car</th>
                        <th>Pickup</th>
                        <th>Drop-off</th>
                        <th>Status</th>
                        <th>Estimated Total:</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rentals as $rental)
                        <tr>
                            <td>{{ $rental->id }}</td>
                            <td>{{ $rental->user->name }}</td>
                            <td>{{ $rental->vehicle->name ?? 'No vehicle assigned' }}</td>
                            <td>{{ $rental->pickup_date }} {{ $rental->pickup_time }}</td>
                            <td>{{ $rental->dropoff_date }} {{ $rental->dropoff_time }}</td>
                            <td>
                                <span class="badge bg-{{ $rental->status === 'confirmed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($rental->status) }}
                                </span>
                            </td>
                            <td>
                                @if ($rental->vehicle)
                                    <p>{{ number_format($rental->calculatetotal(), 0, ',', '.') }}₫</p>
                                @else
                                    <p>--</p>
                                @endif
                            </td>

                            <td>
                                <div class="d-grid gap-2">
                                    @if ($rental->status === 'pending')
                                        <form action="{{ route('admin.rentals.confirm', $rental->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-success w-100">
                                                ✅ Confirm
                                            </button>
                                        </form>
                                    @endif
                                    <a class="btn btn-sm btn-outline-primary w-100"
                                        href="{{ route('admin.rentals.detail', $rental->id) }}"
                                        class="btn btn-sm btn-info">📋
                                        Detail / Edit</a>
                                    @if ($rental->status === 'confirmed')
                                        <a href="{{ route('admin.rentals.payment', $rental->id) }}"
                                            class="btn btn-sm btn-outline-secondary w-100">
                                            💰 Payment
                                        </a>
                                    @endif
                                    @if ($rental->status === 'pending')
                                        <form method="POST" action="{{ route('admin.rentals.cancel', $rental->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-sm btn-outline-danger w-100">
                                                ❌ Cancel
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $rentals->links() }}
            </div>
        </div>
    </main>
@endsection
