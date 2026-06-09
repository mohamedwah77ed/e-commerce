@extends('backend.layouts.master')

@section('title', 'Edit User')

@section('content')

<div class="container py-4" style="max-width: 520px;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">Edit User</h4>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">← Back</a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $user->name) }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $user->email) }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Role <span class="text-danger">*</span></label>
            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="user"  {{ old('role', $user->role) == 'user'  ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <hr class="my-3">
        <p class="text-muted small mb-3">Leave password fields empty to keep the current password.</p>

        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   autocomplete="new-password">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation"
                   class="form-control">
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>

    </form>
</div>

@endsection
