@extends('admin.layout.admin')

@section('content')
    <main role="main" class="main-content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <h2 class="mb-4">User List</h2>

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Google ID</th>
                        <th>Role</th>
                        <th>Registered At</th>
                        <th>Actions</th>
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
                            <td>
                                @if ($user->role != 1)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure want to remove this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                @else
                                    <span class="text-muted">Prohibited Action</span>
                                @endif
                                @if ($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.toggleRole', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Are you want change this user role ?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            @if ($user->role == 1)
                                                Become User
                                            @else
                                                Become Admin
                                            @endif
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">Prohibited Action</span>
                                @endif
                            </td>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </main>
@endsection
