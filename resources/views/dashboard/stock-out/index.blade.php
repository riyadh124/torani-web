@extends('dashboard.layouts.main')

@section('container')
<nav aria-label="breadcrumb" class=" pt-3">
  <ol class="breadcrumb"> 
      <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Stok Keluar</li>
  </ol>
</nav>

<hr>

<a href="{{ url('/export-stock-out') }}" class="btn btn-primary mb-3">
  Export Stock Out
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
          <td>{{ $stock->created_at }}</td>
          <td>

            <a href="/dashboard/stockOut/{{ $stock->id }}" class="badge bg-info">
              <i class="bi bi-eye-fill" style="font-size: 15px"></i>
            </a>
         
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection