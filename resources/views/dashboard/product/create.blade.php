@extends('dashboard.layouts.main')

@section('container')
<nav aria-label="breadcrumb" class="pt-3">
  <ol class="breadcrumb"> 
      <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="/dashboard/product">Produk</a></li>
      <li class="breadcrumb-item active" aria-current="page">Buat Produk Baru</li>
  </ol>
</nav>

<hr>

<div class="col-lg-8">
    <form method="POST" action="/dashboard/product" class="mb-5" enctype="multipart/form-data">
        @csrf
        <!-- Product Name -->
        <div class="mb-3">
          <label for="name" class="form-label">Nama Produk</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" autofocus required>
          @error('name')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <!-- Category -->
        <div class="mb-3">
          <label for="category" class="form-label">Kategori</label>
          <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category') }}" required>
          @error('category')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <!-- Stock Quantity -->
        <div class="mb-3">
          <label for="stock_quantity" class="form-label">Jumlah Stok</label>
          <input type="number" class="form-control @error('stock_quantity') is-invalid @enderror" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" required>
          @error('stock_quantity')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <!-- Unit -->
        <div class="mb-3">
          <label for="unit" class="form-label">Satuan</label>
          <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit" name="unit" value="{{ old('unit') }}" required>
          @error('unit')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <!-- Unit Price -->
        <div class="mb-3">
          <label for="unit_price" class="form-label">Harga Per Satuan</label>
          <input type="number" class="form-control @error('unit_price') is-invalid @enderror" id="unit_price" name="unit_price" value="{{ old('unit_price') }}" step="0.01" required>
          @error('unit_price')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <!-- Thumbnail -->
        <div class="mb-3">
          <label for="thumbnail" class="form-label">Thumbnail Produk</label>
          <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail">
          @error('thumbnail')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Buat Produk</button>
    </form>
</div>

@endsection
