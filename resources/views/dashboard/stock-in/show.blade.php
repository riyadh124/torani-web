@extends('dashboard.layouts.main')

@section('container')
    <nav aria-label="breadcrumb" class=" pt-3">
        <ol class="breadcrumb"> 
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/dashboard/stockIn">Stok Masuk</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Stok Masuk</li>
        </ol>
    </nav>
    
    <hr>

    <p><strong>Catatan:</strong> {{ $stockIn->notes }}</p>
    <p><strong>Tanggal:</strong> {{ $stockIn->created_at->format('d M Y') }}</p>

    <p><strong>Barang yang masuk:</strong></p>
    {{-- <ul>
        @foreach ($stockIn->inventoryItems as $item)
            <li>{{ $item->name }} - {{ $item->pivot->quantity }} {{ $item->unit }}</li>
        @endforeach
    </ul> --}}

    <div class="table-responsive small col-lg-12">
        {{-- <a href="/dashboard/workorder/create" class="btn btn-primary mb-3">Create New Workorder</a> --}}
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Kategori</th>
              <th scope="col">Nama</th>
              <th scope="col">Jumlah</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($stockIn->inventoryItems as $product)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $product->category }}</td>
              <td>{{ $product->name }}</td>
              <td>{{ $product->pivot->quantity }} {{ $product->unit }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    
    {{-- <a href="{{ route('stock_in.list') }}">Kembali ke Daftar Stock In</a> --}}
@endsection
