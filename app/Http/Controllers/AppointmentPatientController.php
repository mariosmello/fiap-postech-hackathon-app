<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

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

    public function cancel(Appointment $appointment, Request $request)
    {
        if ($appointment->patient_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ('canceled' === $appointment->status) {
            return response()->json(['error' => 'Este agendamento já está cancelado'], 409);
        }

        $request->validate([
            'reason' => 'required',
        ]);

        $appointment->update([
            'status' => 'canceled',
            'meeting_url' => null,
            'status_reason' => $request->get('reason')
        ]);
    }

}
