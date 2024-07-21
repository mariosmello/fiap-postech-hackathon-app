<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAvailability;
use Carbon\Carbon;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    // List all appointments
    public function index(User $user)
    {
        $availabilities = UserAvailability::where('user_availabilities.user_id', $user->id)
            ->whereDoesntHave('appointments', function($q) {
                $q->whereNotIn('status', ['declined', 'canceled']);
            })
            ->where(DB::raw("CONCAT(date, ' ', start_time)"), '>', Carbon::now()->format('Y-m-d H:i:s'))
            ->orderBy('date')
            ->orderBy('start_time')
            ->join('user_specialty', function ($join) {
                $join->on('user_availabilities.user_id', '=', 'user_specialty.user_id')
                    ->on('user_availabilities.medical_specialty_id', '=', 'user_specialty.medical_specialty_id');
            })
            ->select('user_availabilities.id', 'user_availabilities.date', 'user_availabilities.start_time',
                'user_availabilities.end_time', 'user_availabilities.medical_specialty_id', 'user_specialty.price')
            ->with('specialty:id,name')
            ->get();

        return response()->json($availabilities);

    }

    // Store a new appointment
    public function store(User $user, UserAvailability $userAvailability)
    {
        if ($userAvailability->appointments()->whereNotIn('status', ['declined', 'canceled'])->count()) {
            return response()->json(['error' => 'Agenda não disponível'], 409);
        }

        Appointment::create([
            'patient_id' => auth()->id(),
            'availability_id' => $userAvailability->id,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Sua consulta foi pré-agendada com sucesso. Aguarde o retorno do médico com a confirmação'
        ], 201);

    }

    public function confirm(Appointment $appointment) {

        $appointment = Appointment::findOrFail($appointment->id);

        if (auth()->id() !== $appointment->availability->user_id) {
            return response()->json(['error' => 'Usuário inválido'], 409);
        }

        if ('pending' !== $appointment->status) {
            return response()->json(['error' => 'Este agendamento não pode ser confirmado'], 409);
        }

        $meeting_url = 'https://meeting.zoom.com.br/room/' . uniqid();

        $appointment->update([
            'status' => 'confirmed',
            'meeting_url' => $meeting_url
        ]);

        return response()->json(['message' => 'Agendamento confirmado']);
    }

    public function decline(Appointment $appointment) {
        $appointment = Appointment::findOrFail($appointment->id);

        if (auth()->id() !== $appointment->availability->user_id) {
            return response()->json(['error' => 'Usuário inválido'], 409);
        }

        if ('declined' === $appointment->status) {
            return response()->json(['error' => 'Este agendamento já está recusado'], 409);
        }

        $appointment->update([
            'status' => 'declined',
            'meeting_url' => null
        ]);

        return response()->json(['message' => 'Agendamento recusado']);
    }

}
