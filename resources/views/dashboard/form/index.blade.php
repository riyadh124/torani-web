@extends('dashboard.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Formulir Laporan</h1>
  </div>

  @if (session()->has('success'))
  <div class="alert alert-success" role="alert">
    {{ session('success') }}
  </div>
  @endif
  
  {{-- @dd($workorders) --}}
  
  <div class="table-responsive small col-lg-12">
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
                  
                    {{-- Add other actions like edit or delete if needed --}}
                    {{-- Example delete form action --}}
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
</div>
@endsection