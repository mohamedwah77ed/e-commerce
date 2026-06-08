@extends('backend.layouts.master')

@section('title', 'Edit Product')

@section('content')

<div class="container py-4" style="max-width: 680px;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="mb-0">Edit Product</h4>
        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">← Back</a>
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

    {{-- Current images --}}
    @if($product->images->count())
        <div class="d-flex flex-wrap gap-2 mb-2">
            @foreach($product->images as $img)
                <div class="position-relative">
                    <img src="{{ asset('uploads/' . $img->image) }}"
                         width="80" height="80"
                         style="object-fit:cover; border-radius:6px;">
                    <form action="{{ route('admin.product.image.delete', $img->id) }}"
                          method="POST"
                          class="position-absolute top-0 end-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="badge bg-danger text-white border-0"
                                style="cursor:pointer; font-size:10px; line-height:1; padding:2px 5px;"
                                onclick="return confirm('Delete this image?')">✕</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title <span class="text-danger">*</span></label>
            <input type="text" name="title"
                   class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title', $product->title) }}" required>
            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Price <span class="text-danger">*</span></label>
                <input type="number" step="0.01" min="0" name="price"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price', $product->price) }}" required>
                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col mb-3">
                <label class="form-label">Discount (%)</label>
                <input type="number" min="0" max="100" name="discount"
                       class="form-control @error('discount') is-invalid @enderror"
                       value="{{ old('discount', $product->discount) }}">
                @error('discount') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Category <span class="text-danger">*</span></label>
                <select name="cat_id" class="form-select @error('cat_id') is-invalid @enderror" required>
                    <option value="">-- Select --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('cat_id', $product->cat_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->title }}
                        </option>
                    @endforeach
                </select>
                @error('cat_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col mb-3">
                <label class="form-label">Brand</label>
                <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                    <option value="">-- Select --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                            {{ $brand->title }}
                        </option>
                    @endforeach
                </select>
                @error('brand_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Stock</label>
                <input type="number" min="0" name="stock"
                       class="form-control @error('stock') is-invalid @enderror"
                       value="{{ old('stock', $product->stock) }}">
                @error('stock') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col mb-3">
                <label class="form-label">Condition</label>
                <select name="condition" class="form-select @error('condition') is-invalid @enderror">
                    <option value="">-- Select --</option>
                    <option value="new"         {{ old('condition', $product->condition) == 'new'         ? 'selected' : '' }}>New</option>
                    <option value="used"        {{ old('condition', $product->condition) == 'used'        ? 'selected' : '' }}>Used</option>
                    <option value="refurbished" {{ old('condition', $product->condition) == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                </select>
                @error('condition') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="active"   {{ old('status', $product->status) == 'active'   ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col mb-3 d-flex align-items-end">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                           id="is_featured" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">Featured Product</label>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Summary <span class="text-danger">*</span></label>
            <textarea name="summary" rows="2"
                      class="form-control @error('summary') is-invalid @enderror"
                      required>{{ old('summary', $product->summary) }}</textarea>
            @error('summary') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4"
                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-4">
            <label class="form-label">Images</label>
            <input type="file" name="images[]" multiple
                   class="form-control @error('images.*') is-invalid @enderror"
                   accept="image/jpg,image/jpeg,image/png">
            <div class="form-text">You can select multiple images — leave empty if you don't want to add new images</div>
            @error('images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>

    </form>
</div>

@endsection
