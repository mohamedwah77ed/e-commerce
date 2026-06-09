@extends('backend.layouts.master')

@section('title', 'Users')

@section('content')

<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">Users</h4>
        <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">Add User</a>
    </div>



    {{-- Search / Filter --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-2 mb-4">
        <div class="col-sm-5">
            <input type="text" name="search" class="form-control form-control-sm"
                   placeholder="Search by name or email..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-sm-3">
            <select name="role" class="form-select form-select-sm">
                <option value="">All Roles</option>
                <option value="user"  {{ request('role') == 'user'  ? 'selected' : '' }}>User</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-sm btn-primary">Filter</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="{{ $user->trashed() ? 'table-danger' : '' }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @else
                            <span class="badge bg-secondary">User</span>
                        @endif
                    </td>
                    <td>
                        @if($user->trashed())
                            <span class="badge bg-danger">Deleted</span>
                            <small class="text-muted d-block">{{ $user->deleted_at->format('d M Y') }}</small>
                        @else
                            <span class="badge bg-success">Active</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        @if(!$user->trashed())
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-outline-info">View</a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                            @endif
                        @else
                            <form action="{{ route('admin.users.restore', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success">Restore</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $users->links() }}
    </div>

</div>

@endsection
