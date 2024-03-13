<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Polyclinic;

class DoctorController extends Controller
{
    //index
    public function index(Request $request)
    {
        $doctors = DB::table('doctors')
            ->when($request->input('name'), function ($query, $doctor_name) {
                return $query->where('doctor_name', 'like', '%' . $doctor_name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.doctors.index', compact('doctors'));
    }
    //create 
    public function create()
    {
        $polyclinics = Polyclinic::all();
        Log::info($polyclinics); // Log the variable
        return view('pages.doctors.create', compact('polyclinics'));
    }

    //show
    public function show($id)
    {
        $doctor = DB::table('doctors')->where('id', $id)->first();
        return view('pages.doctors.show', compact('doctor'));
    }

    //edit
    public function edit($id)
    {
        $doctor = DB::table('doctors')->where('id', $id)->first();
        return view('pages.doctors.edit', compact('doctor'));
    }
    //destroy
    public function destroy($id)
    {
        // Find the doctor to be deleted
        $doctors = Doctor::find($id);

        if (!$doctors) {
            return redirect()->route('doctorss.index')->with('error', 'doctors not found.');
        }


        // Delete the doctors
        $doctors->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully');
    }

    //index polyclinic
    public function indexPolyclinic(Request $request)
    {
        $polyclinics = Polyclinic::all();
        Log::info($polyclinics); // Log the variable
        return view('pages.doctors.create', ['polyclinics' => $polyclinics]);
    }
}
