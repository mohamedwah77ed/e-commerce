@extends('backend.layouts.master')

@section('title', 'Add User')

@section('content')

<div class="container py-4" style="max-width: 520px;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">Add User</h4>
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

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Role <span class="text-danger">*</span></label>
            <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                <option value="user"  {{ old('role') == 'user'  ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password <span class="text-danger">*</span></label>
            <input type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
            <input type="password" name="password_confirmation"
                   class="form-control" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>

    </form>
</div>

@endsection
