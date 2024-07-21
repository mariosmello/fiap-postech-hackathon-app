<?php

namespace App\Http\Controllers;

use App\Actions\IsOverlappingAction;
use Illuminate\Http\Request;
use App\Models\UserAvailability;

class UserAvailabilityController extends Controller
{

    public function index()
    {
        $availabilities = UserAvailability::where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->with('appointments')
            ->get();

        return response()->json($availabilities);
    }

    public function store(Request $request, IsOverlappingAction $isOverlappingAction)
    {
        $request->validate([
            'medical_specialty_id' => 'required|exists:medical_specialties,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        if (!auth()->user()->specialties()->where('medical_specialty_id', $request->medical_specialty_id)->count()) {
            return response()->json(['error' => 'Especialidade inválida para cadastro médico'], 409);
        }

        if ($isOverlappingAction->handler($request->user()->id, $request->date, $request->start_time, $request->end_time)) {
            return response()->json(['error' => 'Este horário já foi criado.'], 409);
        }

        $availability = UserAvailability::create(['user_id' => $request->user()->id] + $request->only(['medical_specialty_id','date','start_time','end_time']));
        return response()->json($availability, 201);
    }

    // Update an existing availability
    public function update(Request $request, IsOverlappingAction $isOverlappingAction, $id)
    {
        $request->validate([
            'medical_specialty_id' => 'required|exists:medical_specialties,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        if (!auth()->user()->specialties()->where('medical_specialty_id', $request->medical_specialty_id)->count()) {
            return response()->json(['error' => 'Especialidade inválida para cadastro médico'], 409);
        }

        if ($isOverlappingAction->handler($request->user()->id, $request->date, $request->start_time, $request->end_time, $id)) {
            return response()->json(['error' => 'Este horário já foi criado.'], 409);
        }

        $availability = UserAvailability::findOrFail($id);
        $availability->update($request->only(['date','start_time','end_time']));
        return response()->json($availability);
    }

    // Delete an availability
    public function destroy($id)
    {
        $availability = UserAvailability::findOrFail($id);
        $availability->delete();
        return response()->json(null, 204);
    }
}
