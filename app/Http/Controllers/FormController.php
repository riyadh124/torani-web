<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormCheck;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FormController extends Controller
{
    /**
     * Display a listing of the forms.
     *
     * @return \Illuminate\Http\Response
     */

     public function uploadPhoto(Request $request)
     {
         // Validasi file yang diunggah
         $request->validate([
             'photo' => 'required|image|max:2048', // Maksimal 2MB
         ]);
 
         // Menyimpan file yang diunggah ke direktori storage/app/public/photos
         $path = $request->file('photo')->store('photos', 'public');
 
         // Mendapatkan URL file
         $url = Storage::url($path);
 
         return response()->json([
             'success' => true,
             'url' => $url,
         ], 201);
     }

    public function index()
    {
        return view('dashboard.form.index',[
            'forms' =>  Form::with('checks','user')->get()
           ]);
    }

   public function getForms()
    {
        $userId = auth()->user()->id;

        // Mendapatkan formulir yang statusnya bukan 'Approved' dan milik pengguna yang sedang login
        $forms = Form::with('user')
            ->where('user_id', $userId)
            ->where('status', '!=', 'Approved')
            ->get();
    
        return response()->json([
            'success' => true,
            'data' => $forms
        ], 200);
    }

    // Method to get details of a form with checks
    public function getDetailForm($id)
    {
        $form = Form::with(['user', 'checks'])->find($id);

        if (!$form) {
            return response()->json([
                'success' => false,
                'message' => 'Form not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $form
        ], 200);
    }

    public function showFormChecks(Form $form)
    {
        // Load the form checks associated with the given form
        // $form->load('checks'); // Assuming 'formDetails' is the relationship method name
        $form = Form::with('checks')->findOrFail($form->id);
        // dd($form);
        return view('dashboard.form.formchecks', compact('form'));
    }

     // Method to approve the form
     public function approve(Request $request, $formId)
     {
         $form = Form::findOrFail($formId);
 
         // Update status to Approved (example)
         $form->status = 'Approved';
         $form->save();
 
         return view('dashboard.form.index',['forms' =>  Form::with('checks')->get()])->with('success', 'Form Approved Successfully');
     }
 
     // Method to reject the form
     public function reject(Request $request, $formId)
     {
         $form = Form::findOrFail($formId);
 
         // Update status to Rejected (example)
         $form->status = 'Rejected';
         $form->save();
 
         return view('dashboard.form.index', ['forms' =>  Form::with('checks')->get()])->with('success', 'Form Rejected Successfully');
     }

    /**
     * Show the form for creating a new form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forms.create');
    }

    /**
     * Store a newly created form in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        // $request->validate([
        //     'user_id' => 'required|exists:users,id',
        //     'nomor_tiket' => 'required|string',
        //     'tipe_unit' => 'required|string',
        //     'model_unit' => 'required|string',
        //     'nomor_unit' => 'required|string',
        //     'shift' => 'required|string',
        //     'jam_mulai' => 'required|date_format:H:i:s',
        //     'jam_selesai' => 'required|date_format:H:i:s',
        //     'hm_awal' => 'required|integer',
        //     'hm_akhir' => 'required|integer',
        //     'job_site' => 'required|string',
        //     'lokasi' => 'required|string',
        //     'status' => 'string',
        //     'catatan' => 'string',
        //     'form_checks' => 'required|array',
        //     'form_checks.*.item_name' => 'required|string',
        //     'form_checks.*.status' => 'required|string',
        //     'form_checks.*.documentation' => 'nullable|string',
        // ]);

        // Attempt to find a form by nomor_tiket
        $form = Form::where('nomor_tiket', $request->nomor_tiket)->first();

        if ($form) {
            // Update existing form
            $form->update([
                'user_id' => $request->user_id,
                'tipe_unit' => $request->tipe_unit,
                'model_unit' => $request->model_unit,
                'nomor_unit' => $request->nomor_unit,
                'shift' => $request->shift,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'hm_awal' => $request->hm_awal,
                'hm_akhir' => $request->hm_akhir,
                'job_site' => $request->job_site,
                'lokasi' => $request->lokasi,
                'status' => $request->status ?? $form->status,
                'catatan' => $request->catatan,
                'status' => 'Waiting'
            ]);


            // return response()->json(['message' => 'Form updated successfully', 'data' => $request->form_checks], 200);


            // Update associated form checks (delete existing and recreate)
            $form->checks()->delete();
            foreach ($request->form_checks as $formCheckData) {
                FormCheck::create([
                    'form_id' => $form->id,
                    'item_name' => $formCheckData['item_name'],
                    'status' => $formCheckData['status'],
                    'documentation' => $formCheckData['documentation'] ?? null,
                ]);
            }

            return response()->json(['message' => 'Form updated successfully'], 200);
        } else {

            $lastTicket = Form::orderBy('created_at', 'desc')->first();
    
            // Jika tidak ada tiket sebelumnya, mulai dari T001
            $nextTicketNumber = 'T001';
            if ($lastTicket) {
                // Ambil nomor tiket terakhir dan extract nomor urutnya
                $lastTicketNumber = $lastTicket->nomor_tiket;
                $lastNumber = intval(substr($lastTicketNumber, 1)); // Ambil angka setelah 'T'
                
                // Increment angka untuk tiket berikutnya
                $nextNumber = $lastNumber + 1;
                $nextTicketNumber = 'T' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT); // Format nomor tiket baru
            }
        
    
            // Create new form
            $form = Form::create([
                'user_id' => $request->user_id,
                'nomor_tiket' => $nextTicketNumber,
                'tipe_unit' => $request->tipe_unit,
                'model_unit' => $request->model_unit,
                'nomor_unit' => $request->nomor_unit,
                'shift' => $request->shift,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'hm_awal' => $request->hm_awal,
                'hm_akhir' => $request->hm_akhir,
                'job_site' => $request->job_site,
                'lokasi' => $request->lokasi,
                'status' => $request->status ?? 'Waiting',
                'catatan' => $request->catatan
            ]);

            // return response()->json(['message' => 'Form updated successfully', 'data' => $request->form_checks], 200);

            // Create associated form checks
            foreach ($request->form_checks as $formCheckData) {
                FormCheck::create([
                    'form_id' => $form->id,
                    'item_name' => $formCheckData['item_name'],
                    'status' => $formCheckData['status'],
                    'documentation' => $formCheckData['documentation'] ?? null,
                ]);
            }

            return response()->json(['message' => 'Form created successfully'], 201);
        }
    }

    /**
     * Display the specified form.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        $form->load('checks'); // Eager load checks relationship
        return view('forms.show', compact('form'));
    }

    /**
     * Show the form for editing the specified form.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        // Load associated checks
        $form->load('checks');
        return view('forms.edit', compact('form'));
    }

    /**
     * Update the specified form in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        $form->update($request->only([
            'user_id', 'nomor_tiket', 'tipe_unit', 'model_unit', 'nomor_unit', 'shift',
            'jam_mulai', 'jam_selesai', 'hm_awal', 'hm_akhir', 'job_site', 'lokasi', 'status','catatan'
        ]));

        // Update or create form checks
        $checksData = $request->only([
            'kondisi_underacarriage_status', 'kondisi_underacarriage_dokumentasi',
            'kerusakan_akibat_insiden_status', 'kerusakan_akibat_insiden_dokumentasi',
            'kebocoran_oli_gearbox_status', 'kebocoran_oli_gearbox_dokumentasi',
            'level_oil_swing_status', 'level_oil_swing_dokumentasi',
            'level_oil_hydraulic_status', 'level_oil_hydraulic_dokumentasi',
            'fuel_drain_status', 'fuel_drain_dokumentasi',
            'bbc_minimum_status', 'bbc_minimum_dokumentasi',
            'buang_air_udara_status', 'buang_air_udara_dokumentasi',
            'kebersihan_accessories_status', 'kebersihan_accessories_dokumentasi',
            'kebocoran_status', 'kebocoran_dokumentasi',
            'alarm_travel_status', 'alarm_travel_dokumentasi',
            'lock_pin_bucket_status', 'lock_pin_bucket_dokumentasi',
            'lock_pin_tooth_status', 'lock_pin_tooth_dokumentasi',
            'kebersihan_aki_status', 'kebersihan_aki_dokumentasi',
            'air_conditioner_status', 'air_conditioner_dokumentasi',
            'fungsi_steering_status', 'fungsi_steering_dokumentasi',
            'fungsi_seat_belt_status', 'fungsi_seat_belt_dokumentasi',
            'fungsi_lampu_status', 'fungsi_lampu_dokumentasi',
            'fungsi_rotary_lamp_status', 'fungsi_rotary_lamp_dokumentasi',
            'fungsi_mirror_status', 'fungsi_mirror_dokumentasi',
            'fungsi_wiper_status', 'fungsi_wiper_dokumentasi',
            'fungsi_horn_status', 'fungsi_horn_dokumentasi',
            'fire_extinguisher_status', 'fire_extinguisher_dokumentasi',
            'fungsi_kontrol_panel_status', 'fungsi_kontrol_panel_dokumentasi',
            'fungsi_radio_komunikasi_status', 'fungsi_radio_komunikasi_dokumentasi',
            'kebersihan_ruangan_status', 'kebersihan_ruangan_dokumentasi',
            'radiator_status', 'radiator_dokumentasi',
            'engine_oli_status', 'engine_oli_dokumentasi',
            // Add other fields as needed
        ]);

        foreach ($checksData as $itemName => $itemData) {
            $formCheck = FormCheck::updateOrCreate(
                ['form_id' => $form->id, 'item_name' => $itemName],
                ['status' => $itemData['status'], 'documentation' => $itemData['dokumentasi'] ?? null]
            );
        }

        return redirect()->route('forms.index');
    }

    /**
     * Remove the specified form from storage.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        $form->delete();
        return redirect()->route('forms.index');
    }
}

