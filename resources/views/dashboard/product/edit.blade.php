@extends('dashboard.layouts.main')

@section('container')
<nav aria-label="breadcrumb" class="pt-3">
  <ol class="breadcrumb"> 
      <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="/dashboard/product">Produk</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit Produk</li>
  </ol>
</nav>

<hr>

<div class="col-lg-8">
    <form method="POST" action="{{ route('product.update', $product->id) }}" class="mb-5" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Specify the PUT method for the update request -->

        <div class="mb-3">
          <label for="name" class="form-label">Nama Produk</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" autofocus required>
          @error('name')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="category" class="form-label">Kategori</label>
          <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category', $product->category) }}" required>
          @error('category')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="stock_quantity" class="form-label">Jumlah Stok</label>
          <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
          @error('stock_quantity')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="unit" class="form-label">Satuan</label>
          <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" value="{{ old('unit', $product->unit) }}" required>
          @error('unit')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="unit_price" class="form-label">Harga Per Satuan</label>
          <input type="number" class="form-control @error('unit_price') is-invalid @enderror" id="unit_price" name="unit_price" value="{{ old('unit_price', $product->unit_price) }}" step="0.01" required>
          @error('unit_price')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="thumbnail" class="form-label">Thumbnail Produk (Opsional)</label>
          <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail">
          @if($product->thumbnail)
              <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="img-fluid mt-2" style="max-width: 200px;">
          @endif
          @error('thumbnail')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Perbarui Produk</button>
    </form>
</div>

@endsection
