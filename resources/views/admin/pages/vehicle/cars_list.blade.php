@extends('admin.layout.admin')


@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            @if (session('msg'))
                                @if (session('msg') === 'Success')
                                    <div class="alert alert-success">Success</div>
                                @else
                                    <div class="alert alert-danger">Failed</div>
                                @endif
                            @endif
                            <h3 class="card-title">Cars List</h3>
                            <form class="form-inline mr-auto searchform text-muted"
                                action="{{ route('admin.vehicle.index') }}" method="get">
                                <input id="keyword" name="keyword"
                                    class="form-control mr-sm-2 bg-transparent border-0 pl-4 text-muted" type="text"
                                    placeholder="Search..." value="{{ request()->get('keyword') ?? '' }}">
                                <div class="form-group mr-2">
                                    <select name="sort" id="sort" class="form-control">
                                        <option value="">-- Sort by --</option>
                                        <option value="latest" {{ request()->get('sort') === 'latest' ? 'selected' : '' }}>
                                            Newest</option>
                                        <option value="oldest" {{ request()->get('sort') === 'oldest' ? 'selected' : '' }}>
                                            Oldest</option>
                                        <option value="price_asc"
                                            {{ request()->get('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to
                                            High</option>
                                        <option value="price_desc"
                                            {{ request()->get('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to
                                            Low</option>
                                    </select>
                                </div>
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                            </form>
                        </div>
                        <div class="card-body">
                            <table class="table datatables">
                                <thead>

                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Brand</th>
                                    <th>Price per day</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Created_at</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $data)
                                        <tr role="row" class="odd">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->brand }}</td>
                                            <td>{{ $data->formatted_price }}</td>
                                            <td
                                                style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ strip_tags($data->description) }}
                                            </td>
                                            <td>
                                                <img src="{{ asset($data->image) }}" alt="{{ $data->name }}"
                                                    width="100">
                                            </td>
                                            <td>{{ $data->ProductCategory->name }}
                                            </td>
                                            <td>
                                                @switch($data->status)
                                                    @case('available')
                                                        <span class="badge badge-success">Available</span>
                                                    @break

                                                    @case('rented')
                                                        <span class="badge badge-warning">Rented</span>
                                                    @break

                                                    @case('pending')
                                                        <span class="badge badge-warning">pending</span>
                                                    @break
                                                    @case('maintenance')
                                                        <span class="badge badge-danger">Maintenance</span>
                                                    @break
                                                    @default
                                                        <span class="badge badge-secondary">Unknow</span>
                                                @endswitch
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('m/d/y H:i:s') }}
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary" type="button"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fe fe-more-horizontal"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{ route('admin.vehicle.detail', ['car' => $data->id]) }}"
                                                            class="dropdown-item">
                                                            <i class="fe fe-eye"></i> Detail
                                                        </a>
                                                        <a href="#" class="dropdown-item text-danger"
                                                            onclick="event.preventDefault(); if(confirm('Are you sure?')) document.getElementById('delete-form-{{ $data->id }}').submit();">
                                                            <i class="fe fe-trash"></i> Delete
                                                        </a>
                                                        <form id="delete-form-{{ $data->id }}"
                                                            action="{{ route('admin.vehicle.destroy', ['car' => $data->id]) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $data->id }}">
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            {{ $datas->appends(request()->all())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
