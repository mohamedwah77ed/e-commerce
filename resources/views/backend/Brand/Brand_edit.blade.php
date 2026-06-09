@extends('backend.layouts.master')
@section('content')
@section('title', 'Edit Brand')

<div class="container py-4" style="max-width: 500px;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">Edit Brand</h4>
        <a href="{{ route('admin.brand.index') }}" class="btn btn-sm btn-outline-secondary">← Back</a>
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

    <form method="POST" action="{{ route('admin.brand.update', $brand->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title"
                   class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title', $brand->title) }}" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="active"   {{ old('status', $brand->status) == 'active'   ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $brand->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.brand.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>

    </form>
</div>

@endsection
