@extends('client.layout.master')

@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('images/bg_3.jpg') }}');"
        data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
                <div class="col-md-9 ftco-animate pb-5">
                    <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i
                                    class="ion-ios-arrow-forward"></i></a></span> <span>Cars <i
                                class="ion-ios-arrow-forward"></i></span></p>
                    <h1 class="mb-3 bread">Choose Your Car</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section bg-light">
        <div class="container">
            <form class="form-inline mr-auto searchform text-muted mb-3" action="{{ route('client.cars.cars_list') }}"
                method="get">
                <input id="keyword" name="keyword" class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted"
                    type="text" placeholder="Find your car..." value="{{ request()->get('keyword') ?? '' }}">
                <div class="form-group mr-2 ">
                    <select name="sort" id="sort" class="form-control mr-sm-2">
                        <option value="">-- Select --</option>
                        <option value="latest" {{ request()->get('sort') === 'latest' ? 'selected' : '' }}>
                            Newest</option>
                        <option value="oldest" {{ request()->get('sort') === 'oldest' ? 'selected' : '' }}>
                            Oldest</option>
                        <option value="price_asc" {{ request()->get('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low
                            to
                            High</option>
                        <option value="price_desc" {{ request()->get('sort') === 'price_desc' ? 'selected' : '' }}>Price:
                            High to
                            Low</option>
                    </select>
                    <select name="category_id" class="form-control w-auto " onchange="this.form.submit()">
                        <option value="">-- Sort by --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </form>
            <div class="row">
                @foreach ($datas as $data)
                    <div class="col-md-4">
                        <div class="car-wrap rounded ftco-animate">
                            <div class="img rounded d-flex align-items-end justify-content-center"
                                style="height: 200px; overflow: hidden;">
                                <img src="{{ asset($data->image) }}" alt="{{ $data->name }}"
                                    style="width: 100%; object-fit: cover;">
                            </div>
                            <div class="text">
                                <h2 class="mb-0"><a href="car-single.html">{{ $data->name }}</a></h2>
                                <div class="d-flex mb-3">
                                    <span class="cat">{{ $data->brand }}</span>
                                    <p class="price ml-auto">{{ number_format($data->price_per_day) }}₫<span>/day</span>
                                    </p>
                                </div>
                                <p class="d-flex mb-0 d-block"><a href="{{ route('client.cars.booking.form') }}"
                                        class="btn btn-primary py-2 mr-1">Book now</a>
                                    <a href="{{ route('client.cars.detail', $data->id) }}"
                                        class="btn btn-secondary py-2 ml-1">Details</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row mt-5">
                <div class="col text-center">
                    {{ $datas->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
