@extends('backend.layouts.master')

@section('title', 'User Details')

@section('content')

<div class="container py-4" style="max-width: 560px;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">User Details</h4>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">← Back</a>
    </div>

    <div class="card border">
        <div class="card-body">
            <table class="table table-borderless mb-0">
                <tr>
                    <th class="text-muted" width="35%">Name</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Role</th>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @else
                            <span class="badge bg-secondary">User</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="text-muted">Email Verified</th>
                    <td>
                        @if($user->email_verified_at)
                            <span class="text-success">✓ {{ $user->email_verified_at->format('d M Y') }}</span>
                        @else
                            <span class="text-danger">Not verified</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="text-muted">Joined</th>
                    <td>{{ $user->created_at->format('d M Y, h:i A') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer bg-white d-flex gap-2">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>

            @if($user->id !== auth()->id())
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                  onsubmit="return confirm('Delete this user?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
            </form>
            @endif
        </div>
    </div>

</div>

@endsection
