<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Appointment;

class DoctorController extends Controller
{
    public function index()
    {
        $users = User::role('doctor')
            ->select(['id', 'name', 'crm', 'rating'])
            ->with('specialties')
            ->when(request('medical_specialty_id'), function ($q) {
                $q->whereHas('specialties', function($q) {
                    $q->where('medical_specialty_id', request('medical_specialty_id'));
                });
            })
            ->when(request('order_by') === 'rating', function ($q) {
                $q->orderBy('rating', 'desc');
            })
            ->orderBy('name')
            ->get();

        return response()->json($users);
    }
}
