@extends('layouts.main')

@section('content')

<div class="container py-4" style="max-width: 640px;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">Add Product</h4>
        <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary">← Back</a>
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

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title"
                   class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title') }}" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Brand <span class="text-danger">*</span></label>
            <input type="text" name="brand"
                   class="form-control @error('brand') is-invalid @enderror"
                   value="{{ old('brand') }}" required>
            @error('brand') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Price <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" name="price"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price') }}" required>
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col mb-3">
                <label class="form-label">Category <span class="text-danger">*</span></label>
                <select name="cat_id" class="form-select @error('cat_id') is-invalid @enderror" required>
                    <option value="">-- Select --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('cat_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->title }}
                        </option>
                    @endforeach
                </select>
                @error('cat_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Summary <span class="text-danger">*</span></label>
            <textarea name="summary"
                      class="form-control @error('summary') is-invalid @enderror"
                      rows="2" required>{{ old('summary') }}</textarea>
            @error('summary') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description"
                      class="form-control @error('description') is-invalid @enderror"
                      rows="4">{{ old('description') }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Image</label>
            <input type="file" name="image"
                   class="form-control @error('image') is-invalid @enderror"
                   accept="image/jpg,image/jpeg,image/png">
            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>

    </form>
</div>

@endsection