<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    style="background-image: url('{{ asset('images/bg_1.jpg') }}'); background-size: cover; background-position: center; min-height: 100vh;">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 ">
        <div>
            <a class="navbar-brand font-weight-bold text-uppercase" style="font-size: 28px;"
                href="{{ route('client.cars.home') }}">
                <span style="color: white">Car</span>
                <span style="color: green">Book</span>
            </a>
        </div>
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <h2>My Rental Orders</h2>

            @if ($rentals->isEmpty())
                <p>You haven't booked any cars yet.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Vehicle</th>
                            <th>Pickup</th>
                            <th>Dropoff</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rentals as $rental)
                            <tr>
                                <td>{{ $rental->vehicle->name ?? 'N/A' }}</td>
                                <td>{{ $rental->pickup_date }} {{ $rental->pickup_time }}</td>
                                <td>{{ $rental->dropoff_date }} {{ $rental->dropoff_time }}</td>
                                <td>{{ ucfirst($rental->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>

</html>
