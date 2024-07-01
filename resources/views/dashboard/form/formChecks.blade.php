@extends('dashboard.layouts.main')

@section('container')
<div class="container">

      <div class=" pt-3 pb-2 mb-3 border-bottom border-top">
        <h5>Form Check Tiket: {{ $form->nomor_tiket }}</h5>
      </div>
      <div class="overflow-hidden border-bottom mb-3 pb-2">
        <div class="row gx-5">
          <div class="col">
            <div class="pb-2">
                <p style="margin: 0">Tipe Unit: {{ $form->tipe_unit }}</p>
                <p style="margin: 0">Model Unit: {{ $form->model_unit }}</p>
                <p style="margin: 0">Nomor Unit: {{ $form->nomor_unit }}</p>
                <p style="margin: 0">Shift: {{ $form->shift }}</p>
                <p style="margin: 0">Tipe Unit: {{ $form->tipe_unit }}</p>
                <p style="margin: 0">Jam: {{ $form->jam_mulai }} - {{ $form->jam_selesai }}</p>
                <p style="margin: 0">HM Awal: {{ $form->hm_awal }}</p>
                <p style="margin: 0">HM Akhir: {{ $form->hm_akhir }}</p>
                <p style="margin: 0">Job Site: {{ $form->job_site }}</p>
                <p style="margin: 0">Lokasi: {{ $form->lokasi }}</p>
                <p style="margin: 0">Status: {{ $form->status }}</p>
              </div>
          </div>
          <div class="col">
            <div class="pb-2">
                <p style="margin: 0">Nama Operator: {{ $form->user->name }}</p>
                <p style="margin: 0">Role: {{ $form->user->role }}</p>
                <p style="margin: 0">ID Karyawan: {{ $form->user->id }}</p>
              </div>
          </div>
        </div>
      </div>

     
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Dokumentasi</th>
                </tr>
            </thead>
         
            <tbody>
                @foreach ($form->checks as $formChecks)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $formChecks->item_name }}</td>
                    <td>{{ $formChecks->status }}</td>
                    <td>
                        <img src="{{ asset( $formChecks->documentation) }}" style="height:100px;" alt="" srcset="">
                    </td>
                    <!-- Add other form check fields here -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="m-3">
        <form action="{{ route('forms.approve', ['form' => $form->id]) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success">Approve</button>
        </form>

        <form action="{{ route('forms.reject', ['form' => $form->id]) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger ml-2">Reject</button>
        </form>
    </div>
</div>
@endsection