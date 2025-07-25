@extends('admin.layout.admin')

@section('content')
<main role="main" class="main-content">
    <div class="container-fluid">
        <h2 class="mb-4">User List</h2>

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
                @foreach($users as $user)
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
    </div>
</main>
@endsection
