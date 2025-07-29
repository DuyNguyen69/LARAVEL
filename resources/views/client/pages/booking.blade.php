@extends('client.layout.master')

@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('images/bg_3.jpg') }}');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{route('client.cars.home')}}">Home <i
                                    class="ion-ios-arrow-forward"></i></a></span> <span>Booking <i
                                class="ion-ios-arrow-forward"></i></span></p>
                    <h1 class="mb-3 bread">Booking</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-cart">
        <div class="container ">
            <form action="{{ route('client.cars.booking.submit') }}" method="POST" class="bg-light p-4 rounded shadow-sm">
                @csrf
                <input type="hidden" name="car_id" id="selectedVehicleId" value="{{ old('car_id') }}">
                <div class="row">
                    <div class="col-md-4">
                        <h3 class="text-center mb-4">Confirm Your Booking</h3>
                        <div class="form-group mb-3">
                            <label for="customer_name">Full Name</label>
                            <input type="text" name="customer_name" class="form-control"
                                value="{{ old('customer_name', $user->name ?? '') }}">
                        </div>
                        @error('customer_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group mb-3">
                            <label for="customer_phone">Phone Number</label>
                            <input type="text" name="customer_phone" class="form-control"
                                value="{{ old('customer_phone', $user->phone ?? '') }}">
                        </div>
                        @error('customer_phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group mb-3">
                            <label for="customer_email">Email</label>
                            <input type="text" name="customer_email" class="form-control"
                                value="{{ old('customer_email', $user->email ?? '') }}">
                        </div>
                        @error('customer_email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group mb-4">
                            <label for="customer_id_number">ID / CCCD</label>
                            <input type="text" name="customer_id_number" class="form-control"
                                value="{{ old('customer_id_number') }}">
                        </div>
                        @error('customer_id_number')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group mb-3">
                            <label for="delivery_option">Delivery Method</label>
                            <select name="delivery_option" id="delivery_option" class="form-control">
                                <option value="">-- Please choose --</option>
                                <option value="pickup_self"
                                    {{ old('delivery_option') == 'pickup_self' ? 'selected' : '' }}>Pick up at location
                                </option>
                                <option value="delivery_to_location"
                                    {{ old('delivery_option') == 'delivery_to_location' ? 'selected' : '' }}>Deliver to my
                                    location</option>
                            </select>
                        </div>
                        @error('delivery_option')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group mb-3" id="delivery_address_group" style="display: none;">
                            <label for="delivery_address">Delivery Address</label>
                            <input type="text" name="delivery_address" id="delivery_address" class="form-control"
                                value="{{ old('delivery_address') }}" placeholder="Enter your delivery address">
                        </div>
                        @error('delivery_address')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-3">
                                <label for="pickup_date">Pick-up Date</label>
                                <input type="date" name="pickup_date" class="form-control"
                                    value="{{ old('pickup_date') }}">
                            </div>
                            @error('pickup_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group col-md-6 mb-3">
                                <label for="dropoff_date">Drop-off Date</label>
                                <input type="date" name="dropoff_date" class="form-control"
                                    value="{{ old('dropoff_date') }}">
                            </div>
                            @error('dropoff_date')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="pickup_time">Pick-up Time</label>
                            <input type="time" name="pickup_time" class="form-control" value="{{ old('pickup_time') }}" placeholder="00:00">
                        </div>
                        @error('pickup_time')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group mb-3">
                            <label for="dropoff_time">Drop-off Time</label>
                            <input type="time" name="dropoff_time" class="form-control"
                                value="{{ old('dropoff_time') }}" placeholder="00:00">
                        </div>
                        @error('dropoff_time')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary px-4">Confirm Booking</button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="mb-4">Choose a car</h3>
                        <div class="row">
                            @error('car_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            @foreach ($cars as $car)
                                <div class="col-md-4 mb-4 px-2">
                                    <div class="card vehicle-card h-100 shadow-sm border rounded position-relative"
                                        id="vehicle_card_{{ $car->id }}">
                                        <img src="{{ asset($car->image) }}" class="card-img-top"
                                            alt="{{ $car->name }}"
                                            style="height: 150px; object-fit: cover; cursor: pointer;"
                                            onclick="openVehicleModal(
                        '{{ asset($car->image) }}',
                        '{{ $car->name }}',
                        `{!! $car->description !!}` )">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{{ $car->name }}</h5>
                                            <p class="card-text text-muted">{{ number_format($car->price_per_day) }}
                                                VND/day
                                            </p>
                                            <button type="button" id="rent_btn_{{ $car->id }}"
                                                class="btn btn-outline-primary btn-sm rent-btn"
                                                onclick="selectVehicle({{ $car->id }})">
                                                Rent
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </section>
    <!-- Vehicle Detail Modal -->
    <div class="modal fade" id="vehicleModal" tabindex="-1" aria-labelledby="vehicleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vehicleModalLabel">Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex flex-column align-items-center text-center">
                    <img id="modalVehicleImage" src="" class="img-fluid mb-3"
                        style="max-height: 300px; object-fit: cover;">
                    <h4 id="modalVehicleName"></h4>
                    <p id="modalVehicleDescription" class="text-muted"></p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('my-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deliveryOption = document.getElementById('delivery_option');
            const deliveryAddressGroup = document.getElementById('delivery_address_group');

            deliveryOption.addEventListener('change', function() {
                if (this.value === 'delivery_to_location') {
                    deliveryAddressGroup.style.display = 'block';
                } else {
                    deliveryAddressGroup.style.display = 'none';
                }
            });
        });

        function selectVehicle(carId) {
            document.getElementById('selectedVehicleId').value = carId;

            // Reset tất cả nút Rent
            document.querySelectorAll('.rent-btn').forEach(btn => {
                btn.classList.remove('active', 'btn-primary');
                btn.classList.add('btn-outline-primary');
                btn.innerText = 'Rent';
            });

            // Đánh dấu nút Rent được chọn
            const rentBtn = document.getElementById('rent_btn_' + carId);
            if (rentBtn) {
                rentBtn.classList.remove('btn-outline-primary');
                rentBtn.classList.add('btn-primary', 'active');
                rentBtn.innerText = 'Rented';
            }
        }


        function openVehicleModal(imageUrl, name, description) {
            document.getElementById('modalVehicleImage').src = imageUrl;
            document.getElementById('modalVehicleName').textContent = name;
            document.getElementById('modalVehicleDescription').innerHTML = description;


            const vehicleModal = new bootstrap.Modal(document.getElementById('vehicleModal'));
            vehicleModal.show();
        }

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

        flatpickr("input[name='pickup_time']", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });

        flatpickr("input[name='dropoff_time']", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true
        });
    </script>
@endsection
