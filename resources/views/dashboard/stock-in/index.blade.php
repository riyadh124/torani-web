@extends('dashboard.layouts.main')

@section('container')
  <nav aria-label="breadcrumb" class=" pt-3">
    <ol class="breadcrumb"> 
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Stok Masuk</li>
    </ol>
  </nav>

  <hr>

  <a href="{{ url('/export-stock-in') }}" class="btn btn-success mb-3">
    Export Stock In
  </a>

  <a href="{{ url('/dashboard/stockIn/create') }}" class="btn btn-primary mb-3">
    Tambah Stock Masuk
  </a>

  @if (session()->has('success'))
  <div class="alert alert-success" role="alert">
    {{ session('success') }}
  </div>
  @endif
  
  {{-- @dd($workorders) --}}
  
  <div class="table-responsive small col-lg-12">
    {{-- <a href="/dashboard/workorder/create" class="btn btn-primary mb-3">Create New Workorder</a> --}}
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Catatan</th>
          <th scope="col">Waktu</th>
        </tr>
      </thead>
      <tbody>
      
        @foreach ($stocks as $stock)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $stock->notes }}</td>
          <td>{{ \Carbon\Carbon::parse($stock->created_at)->timezone('Asia/Makassar')->translatedFormat('l, d F Y, H:i') }}</td>
          <td>

            <a href="/dashboard/stockIn/{{ $stock->id }}" class="badge bg-info">
              <i class="bi bi-eye-fill" style="font-size: 15px"></i>
            </a>

          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection