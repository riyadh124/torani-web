@extends('dashboard.layouts.main')

@section('container')
<nav aria-label="breadcrumb" class=" pt-3">
  <ol class="breadcrumb"> 
      <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
  </ol>
</nav>

<hr>

  @if (session()->has('success'))
  <div class="alert alert-success" role="alert">
    {{ session('success') }}
  </div>
  @endif
  
<div class="row g-2">
  <div class="col-6">
    <div style="background-color:#0080F6;border-radius:20px" class="p-3">
      <p class="text-white fw-bold fs-4">{{ $totalProducts }}</p>
      <p class="fw-bold fs-5" style="color: #BDDEFC">Total Produk</p>
    </div>
  </div>
  <div class="col-6">
    <div style="background-color:#59CCF1;border-radius:20px" class="p-3">
      <p class="text-white fw-bold fs-4">{{ $currentStock }}</p>
      <p class="fw-bold fs-5" style="color: #BDDEFC">Stok Saat Ini</p>
    </div>
  </div>
  <div class="col-6">
    <div style="background-color:#0080F6;border-radius:20px" class="p-3">
      <p class="text-white fw-bold fs-4">{{ $totalStockIn }}</p>
      <p class="fw-bold fs-5" style="color: #BDDEFC">Total Stok Masuk</p>
    </div>
  </div>
  <div class="col-6">
    <div style="background-color:#59CCF1;border-radius:20px" class="p-3">
      <p class="text-white fw-bold fs-4">{{ $totalStockOut }}</p>
      <p class="fw-bold fs-5" style="color: #BDDEFC">Total Stok Keluar</p>
    </div>
  </div>
</div>


  
  {{-- <div class="table-responsive small col-lg-12">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nomor Tiket</th>
                <th scope="col">Tipe Unit</th>
                <th scope="col">Model Unit</th>
                <th scope="col">Nomor Unit</th>
                <th scope="col">Nama Operator</th>
                <th scope="col">ID Operator</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($forms as $form)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $form->nomor_tiket }}</td>
                <td>{{ $form->tipe_unit }}</td>
                <td>{{ $form->model_unit }}</td>
                <td>{{ $form->nomor_unit }}</td>       
                <td>{{ $form->user->name }}</td>
                <td>{{ $form->user->id }}</td>
                <td>{{ $form->status }}</td>
                <td>
                    <a href="{{ route('forms.formchecks', ['form' => $form->id]) }}" class="badge bg-info">
                        <i class="bi bi-eye-fill" style="font-size: 15px"></i>
                    </a>
                  
                    <form action="{{ route('forms.destroy', ['form' => $form->id]) }}" method="POST" class="d-inline">
                        @method('DELETE')
                        @csrf
                        <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')">
                            <i class="bi bi-trash-fill" style="font-size: 15px"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
  </div> --}}
@endsection