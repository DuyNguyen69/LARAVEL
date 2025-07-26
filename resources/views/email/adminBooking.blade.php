<h2>New Car Booking</h2>
<p><strong>User:</strong> {{ $rental->user->name ?? 'Guest' }}</p>
<p><strong>Car:</strong> {{ $rental->vehicle->name }}</p>
<p><strong>Pickup:</strong> {{ $rental->pickup_date }}</p>
<p><strong>Pickup-Time:</strong> {{ $rental->pickup_time }}</p>
<p><strong>Drop-off:</strong> {{ $rental->dropoff_date }}</p>
<p><strong>Drop-off-time:</strong> {{ $rental->dropoff_time }}</p>
<p><strong>Total Price:</strong> {{ number_format($rental->calculatetotal(), 0, ',', '.') }}₫ VND</p>
