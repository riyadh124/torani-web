@extends('dashboard.layouts.main')

@section('container')
<nav aria-label="breadcrumb" class="pt-3">
  <ol class="breadcrumb"> 
      <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="/dashboard/user">Akun Pengguna</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit Akun Pengguna</li>
  </ol>
</nav>

<hr>

<div class="col-lg-8">
    <form method="POST" action="{{ route('user.update', $user->id) }}" class="mb-5">
        @csrf
        @method('PUT') <!-- Specify the PUT method for the update request -->

        <div class="mb-3">
          <label for="name" class="form-label">Nama</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" autofocus required>
          @error('name')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
          @error('email')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>
        
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                <option value="Owner" {{ old('role', $user->role) === 'Owner' ? 'selected' : '' }}>Owner</option>
                <option value="Manajer" {{ old('role', $user->role) === 'Manajer' ? 'selected' : '' }}>Manajer</option>
                <option value="Karyawan" {{ old('role', $user->role) === 'Karyawan' ? 'selected' : '' }}>Karyawan</option>
            </select>
            @error('role')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <!-- Optional Password Field (only if the user wants to update it) -->
        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi Baru (Opsional)</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
            @error('password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Perbarui Akun</button>
    </form>
</div>

@endsection
