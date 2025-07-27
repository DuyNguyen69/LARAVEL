@extends('admin.layout.admin')


@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div id="status_chart" style="height: 400px;"></div>
                </div>
                <div class="col-md-6">
                    <div id="top_cars_chart" style="height: 400px;"></div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div id="monthly_revenue_chart" style="height: 400px;"></div>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Google ID</th>
                                <th>Role</th>
                                <th>Registered At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->google_user_id ?? '—' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role == 1 ? 'primary' : 'secondary' }}">
                                            {{ $user->role == 1 ? 'Admin' : 'User' }}
                                        </span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>

    </main>
@endsection

@section('my-js')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        // Load thư viện Google Charts
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            drawBookingStatusChart();
            drawMostRentedCarsChart();
        }

        
        function drawBookingStatusChart() {
            var data = google.visualization.arrayToDataTable([
                ['Status', 'Amout'],
                ['Completed', {{ $completedCount }}],
                ['Canceled', {{ $canceledCount }}],
            ]);

            var options = {
                title: 'Rentals Status',
                colors: ['#28a745', '#dc3545'],
                pieHole: 0.4
            };

            var chart = new google.visualization.PieChart(document.getElementById('status_chart'));
            chart.draw(data, options);
        }

        // Biểu đồ 2: Xe được đặt nhiều nhất
        function drawMostRentedCarsChart() {
            var data = google.visualization.arrayToDataTable([
                ['Cars', 'Bookings'],
                @foreach ($mostRentedCars as $car)
                    ['{{ $car->vehicle->name }}', {{ $car->total }}],
                @endforeach
            ]);

            var options = {
                title: 'Top most booked cars',
                hAxis: {
                    title: 'Cars'
                },
                vAxis: {
                    title: 'Amount'
                },
                colors: ['#007bff'],
                legend: {
                    position: 'none'
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('top_cars_chart'));
            chart.draw(data, options);
        }
    </script>
    <script type="text/javascript">
        google.charts.setOnLoadCallback(drawMonthlyRevenue);

        function drawMonthlyRevenue() {
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Revenue (VND)'],
                @for ($i = 1; $i <= 12; $i++)
                    ['Month {{ $i }}', {{ $monthlyRevenue[$i] ?? 0 }}],
                @endfor
            ]);

            var options = {
                title: 'Monthly Revenue',
                hAxis: {
                    title: 'Month',
                    format: '0',
                    gridlines: {
                        count: 12
                    }
                },
                vAxis: {
                    title: 'Revenue (VND)'
                },
                legend: {
                    position: 'none'
                },
                colors: ['#4CAF50']
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('monthly_revenue_chart'));
            chart.draw(data, options);
        }
    </script>
@endsection
