<?php

namespace App\Http\Controllers;

use App\Models\MedicalSpecialty;

class MedicalSpecialtyController extends Controller
{
    public function index()
    {
        $specialties = MedicalSpecialty::select(['id', 'name', 'description'])
            ->withCount('users')
            ->orderBy('name')
            ->get();

        return response()->json($specialties);
    }
}
