<?php

namespace App\Http\Controllers;

use App\Models\Appointment;

class AppointmentPatientController extends Controller
{
    // List all appointments
    public function index()
    {
        $appointments = Appointment::where('patient_id', auth()->id())
            ->with('availability')
            ->get();

        return response()->json($appointments);

    }

}
