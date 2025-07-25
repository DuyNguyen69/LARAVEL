@extends('admin.layout.admin')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recycle List</h3>
                        </div>
                        <div class="card-body">
                            <table class="table datatables">
                                <thead>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Brand</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($cars as $car)
                                        <tr role="row" class="odd">
                                            <td>{{ $car->id }}</td>
                                            <td>{{ $car->name }}</td>
                                            <td>{{ $car->brand }}</td>
                                            <td>
                                                <form action="{{ route('admin.vehicle.restore', $car->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                                </form>
                                                <form action="{{ route('admin.vehicle.forceDelete', $car->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            {{ $cars->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
