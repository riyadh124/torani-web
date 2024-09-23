@extends('dashboard.layouts.main')

@section('container')
<nav aria-label="breadcrumb" class="pt-3">
  <ol class="breadcrumb"> 
      <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="/dashboard/stockIn">Stock In</a></li>
      <li class="breadcrumb-item active" aria-current="page">Tambah Stock In Baru</li>
  </ol>
</nav>

<hr>

<div class="col-lg-8">
    <form method="POST" action="{{ route('stockIn.store') }}" class="mb-5">
        @csrf

        <!-- Stock In Notes -->
        <div class="mb-3">
          <label for="notes" class="form-label">Catatan</label>
          <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes">{{ old('notes') }}</textarea>
          @error('notes')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <!-- Search Bar (Make sure this is above the product list) -->
        <div class="mb-3">
            <label for="productSearch" class="form-label">Cari Produk</label>
            <input type="text" id="productSearch" class="form-control" placeholder="Cari produk berdasarkan nama...">
        </div>

        <!-- Loop through each inventory item and allow quantity input -->
        <div id="productList">
            @foreach($inventoryItems as $item)
                <div class="mb-3 product-item" data-name="{{ strtolower($item->name) }}">
                    <label class="form-label">{{ $item->name }} ({{ $item->unit }})</label>
                    <input type="hidden" name="items[{{ $loop->index }}][inventory_item_id]" value="{{ $item->id }}">
                    <input type="number" class="form-control quantity-input @error('items.{{ $loop->index }}.quantity') is-invalid @enderror" name="items[{{ $loop->index }}][quantity]" value="{{ old('items.'.$loop->index.'.quantity', 0) }}" min="0">
                    @error('items.{{ $loop->index }}.quantity')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                    @enderror
                </div>
            @endforeach
        </div>

        <!-- Submit Button to Store Stock In -->
        <button type="submit" class="btn btn-primary" id="submitBtn">Tambah Stock In</button>
    </form>
</div>

<!-- Add JavaScript to enable search functionality -->
<script>
    document.getElementById('productSearch').addEventListener('keyup', function() {
        var searchQuery = this.value.toLowerCase();
        var products = document.querySelectorAll('.product-item');

        products.forEach(function(product) {
            var productName = product.getAttribute('data-name');
            if (productName.includes(searchQuery)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    });
</script>

@endsection
