@extends('admin.layout.admin')

@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <h2 class="mb-4">Payment List</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Rental ID</th>
                    <th>Customer</th>
                    <th>Vehicle</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Paid At</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ $payment->rental_id }}</td>
                        <td>{{ $payment->rental->user->name ?? '-' }}</td>
                        <td>{{ $payment->rental->vehicle->name ?? '-' }}</td>
                        <td>{{ number_format($payment->total_price, 0, ',', '.') }}₫</td>
                        <td>
                            @if ($payment->status === 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No payment found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $payments->links() }}
    </div>
</main>
@endsection
