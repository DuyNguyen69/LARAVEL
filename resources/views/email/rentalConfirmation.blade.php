<h2>Xác nhận đặt xe thành công</h2>

<p>Chào {{ $rental->customer_name }},</p>

<p>Bạn đã đặt xe thành công. Dưới đây là thông tin chi tiết:</p>

<ul>
    <li><strong>Xe:</strong> {{ $rental->vehicle->name }}</li>
    <li><strong>Ngày nhận:</strong> {{ $rental->start_date }}</li>
    <li><strong>Ngày trả:</strong> {{ $rental->end_date }}</li>
    <li><strong>Số điện thoại:</strong> {{ $rental->customer_phone }}</li>
    <li><strong>CMND/CCCD:</strong> {{ $rental->customer_id_number }}</li>
    <li><strong>Hình thức giao nhận:</strong> {{ $rental->delivery_option == 'delivery_to_location' ? 'Giao tận nơi' : 'Tự đến lấy' }}</li>
    <li><strong>Tổng tiền dự tính: {{ number_format($rental->calculatetotal(), 0, ',', '.') }}₫ VND</strong></li>
    @if ($rental->delivery_address)
        <li><strong>Địa chỉ giao xe:</strong> {{ $rental->delivery_address }}</li>
    @endif
</ul>

<p>Cảm ơn bạn đã sử dụng dịch vụ!</p>
