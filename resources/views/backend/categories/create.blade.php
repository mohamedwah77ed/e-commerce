@extends('backend.layouts.master')

@section('title', 'Add Category')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Add Category</h4>
            <small class="text-muted">Create a new category</small>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="mb-0 fw-semibold"><i class="bi bi-grid me-2 text-primary"></i>Category Details</h6>
                </div>
                <div class="card-body p-4">

                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf

                        {{-- Title --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium">Title <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}"
                                   placeholder="Category title...">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Summary --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium">Summary</label>
                            <textarea name="summary"
                                      class="form-control @error('summary') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Short description...">{{ old('summary') }}</textarea>
                            @error('summary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Is Parent --}}
                        <div class="mb-3">
                            <label class="form-label fw-medium">Type <span class="text-danger">*</span></label>
                            <select name="is_parent"
                                    class="form-select @error('is_parent') is-invalid @enderror"
                                    id="isParentSelect">
                                <option value="1" {{ old('is_parent', '1') == '1' ? 'selected' : '' }}>Parent Category</option>
                                <option value="0" {{ old('is_parent') == '0' ? 'selected' : '' }}>Sub Category</option>
                            </select>
                            @error('is_parent')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Parent ID — بيظهر بس لو Sub --}}
                        <div class="mb-3" id="parentField" style="{{ old('is_parent') == '0' ? '' : 'display:none' }}">
                            <label class="form-label fw-medium">Parent Category <span class="text-danger">*</span></label>
                            <select name="parent_id"
                                    class="form-select @error('parent_id') is-invalid @enderror">
                                <option value="">-- Select Parent --</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label class="form-label fw-medium">Status <span class="text-danger">*</span></label>
                            <select name="status"
                                    class="form-select @error('status') is-invalid @enderror">
                                <option value="active"   {{ old('status') == 'active'   ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', 'inactive') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg me-1"></i> Save Category
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary px-4">
                                Cancel
                            </a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
    // لو اختار Sub تظهر قائمة الـ Parent
    document.getElementById('isParentSelect').addEventListener('change', function () {
        const parentField = document.getElementById('parentField');
        parentField.style.display = this.value === '0' ? 'block' : 'none';
    });
</script>
@endsection
