@extends('layouts.main')

@section('content')
{{ __('messages.welcome') }}

<div class="d-flex justify-content-between mb-3">
    <h3>Products</h3>
    <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
</div>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">Navbar</a>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th> Category</th>
                
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->title }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ asset('uploads/'.$product->image) }}" width="70" alt="{{ $product->title }}">
                    @else
                        <span class="text-muted">No image</span>
                    @endif
                </td>
                <td>{{ $product->cat_info?->title ?? 'Uncategorized' }}</td>
                <td class="text-nowrap">
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>

                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>

                    <form action="{{ route('add-to-cart') }}" method="POST" class="d-inline">
                        @csrf
                        
                        <input type="hidden" name="slug" value="{{ $product->slug }}">                
                        <button type="submit" class="btn btn-success btn-sm ms-1">Add to Cart</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No products found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection