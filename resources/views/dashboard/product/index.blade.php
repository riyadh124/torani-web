@extends('dashboard.layouts.main')

@section('container')

<nav aria-label="breadcrumb" class=" pt-3">
  <ol class="breadcrumb"> 
      <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Produk</li>
  </ol>
</nav>

<hr>

@if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<a href="{{ url('/export-products') }}" class="btn btn-success mb-3">
  Download Product Data as Excel
</a>

<a href="/dashboard/product/create" class="btn btn-primary mb-3">Buat Produk Baru</a>
  
  {{-- @dd($products) --}}
  
  <div class="table-responsive small col-lg-12">
    {{-- <a href="/dashboard/product/create" class="btn btn-primary mb-3">Create New product</a> --}}
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Kategori</th>
          <th scope="col">Nama</th>
          <th scope="col">Jumlah</th>
          <th scope="col">Harga</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $product)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $product->category }}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->stock_quantity }}</td>
          <td>{{ $product->unit_price }}</td>
          <td>
            {{-- <a href="/dashboard/product/{{ $product->id }}" class="badge bg-info">
              <i class="bi bi-eye-fill" style="font-size: 15px"></i>
            </a> --}}
            <a href="/dashboard/product/{{ $product->id }}/edit" class="badge bg-warning">
              <i class="bi bi-pencil-fill"  style="font-size: 15px"></i>
            </a>

            <form action="/dashboard/product/{{ $product->id }}" method="POST" class="d-inline">
            @method('delete')
            @csrf
            <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')"> 
              <i class="bi bi-trash-fill"  style="font-size: 15px"></i>
            </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection