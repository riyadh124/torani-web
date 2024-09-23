@extends('dashboard.layouts.main')

@section('container')
<nav aria-label="breadcrumb" class=" pt-3">
  <ol class="breadcrumb"> 
      <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Akun Pengguna</li>
  </ol>
</nav>

<hr>

  @if (session()->has('success'))
  <div class="alert alert-success" role="alert">
    {{ session('success') }}
  </div>
  @endif
  
  {{-- @dd($workorders) --}}
  
  <div class="table-responsive small col-lg-12">
    <a href="/dashboard/user/create" class="btn btn-primary mb-3">Buat Akun Baru</a>
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama</th>
          <th scope="col">Email</th>
          <th scope="col">Role</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $user)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->role }}</td>
          <td>
            {{-- <a href="/dashboard/user/{{ $user->id }}" class="badge bg-info">
              <i class="bi bi-eye-fill" style="font-size: 15px"></i>
            </a> --}}
            <a href="/dashboard/user/{{ $user->id }}/edit" class="badge bg-warning">
              <i class="bi bi-pencil-fill"  style="font-size: 15px"></i>
            </a>

            <form action="/dashboard/user/{{ $user->id }}" method="POST" class="d-inline">
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