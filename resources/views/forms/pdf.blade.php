<!DOCTYPE html>
<html>
<head>
    <title>Form Check Tiket: {{ $form->nomor_tiket }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { padding: 20px; }
        .border-bottom { border-bottom: 1px solid #000; }
        .mt-3 { margin-top: 1rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <div class="container">
        <div class="border-bottom">
            <h3>Form Check Tiket: {{ $form->nomor_tiket }}</h3>
        </div>
        <div class="mt-3">
            <p>Tipe Unit: {{ $form->tipe_unit }}</p>
            <p>Model Unit: {{ $form->model_unit }}</p>
            <p>Nomor Unit: {{ $form->nomor_unit }}</p>
            <p>Shift: {{ $form->shift }}</p>
            <p>Jam: {{ $form->jam_mulai }} - {{ $form->jam_selesai }}</p>
            <p>HM Awal: {{ $form->hm_awal }}</p>
            <p>HM Akhir: {{ $form->hm_akhir }}</p>
            <p>Job Site: {{ $form->job_site }}</p>
            <p>Lokasi: {{ $form->lokasi }}</p>
            <p>Status: {{ $form->status }}</p>
            <p>Catatan: {{ $form->catatan }}</p>
            <p>Catatan Supervisor: {{ $form->catatan_spv }}</p>
        </div>
        <div class="mt-3">
            <table>
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
                        @if (is_file(public_path($formChecks->documentation)))
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path( $formChecks->documentation))) }}" style="height:100px;" alt="">
                    @else
                        <p>No Image.</p>
                    @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>