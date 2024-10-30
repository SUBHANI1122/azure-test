<?php

namespace App\Http\Controllers;

use App\Models\Appoinment;
use App\Models\ClinicNote;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AppoinmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'appointment_id' => 'required|exists:appoinments,id',
            'bp' => 'nullable|string|max:10',
            'pc' => 'nullable|string|max:255',
            'medicines' => 'nullable|array',
            'medicines.*' => 'exists:medicines,id',
            'lab_tests' => 'nullable|array',
            'lab_tests.*' => 'exists:labs,id',
            'prescription' => 'nullable|string|max:1000',
        ]);

        $validatedData['dm'] = $request->has('dm');
        $validatedData['ht'] = $request->has('ht');

        $appointment = Appoinment::findOrFail($validatedData['appointment_id']);
        // Save clinic notes in the separate clinic_notes table
        $clinicNote = ClinicNote::firstOrNew(['appointment_id' => $appointment->id]);

        // Fill the clinic note details and save
        $clinicNote->fill([
            'dm' => $validatedData['dm'] ?? false,
            'ht' => $validatedData['ht'] ?? false,
            'bp' => $validatedData['bp'],
            'pc' => $validatedData['pc'],
        ]);
        $clinicNote->save();

        DB::table('appointment_medicine')->where(['appointment_id' => $appointment->id])->delete();

        if ($request->filled('medicines')) {
            DB::table('appointment_medicine')
                ->where('appointment_id', $request->appointment_id)
                ->delete();

            foreach ($request->medicines as $medicineId) {
                DB::table('appointment_medicine')->insert([
                    'appointment_id' => $request->appointment_id,
                    'medicine_id' => $medicineId,
                    'days' => $request->days[$medicineId] ?? null, 
                    'created_at' => now(), 
                    'updated_at' => now(), 
                ]);
            }
        }

        if (!empty($validatedData['lab_tests'])) {
            DB::table('appointment_lab_test')
                ->where('appointment_id', $request->appointment_id)
                ->delete();

            foreach ($validatedData['lab_tests'] as $labTestId) {
                DB::table('appointment_lab_test')->insert([
                    'appointment_id' => $request->appointment_id,
                    'lab_test_id' => $labTestId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $prescription = Prescription::firstOrNew(['appointment_id' => $appointment->id]);

        $prescription->instructions = $validatedData['prescription'];
        $prescription->save();

        // Return a response
        return response()->json(['success' => true, 'message' => 'Appointment details added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appoinment  $appoinment
     * @return \Illuminate\Http\Response
     */
    public function show(Appoinment $appoinment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appoinment  $appoinment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appoinment $appoinment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appoinment  $appoinment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appoinment $appoinment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appoinment  $appoinment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appoinment $appoinment)
    {
        //
    }
}
