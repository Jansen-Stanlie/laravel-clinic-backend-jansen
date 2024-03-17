<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Polyclinic;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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

    //store
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'nik' => ['required', 'digits:16', Rule::unique('doctors')],
            'sip' => ['required', 'regex:/^\d{5}-\d{5}\/DU\.\d{4}\/\d{2}\.\d{1}\/\d{3}\.\d{1}\/\d{3}\/[IVXLCDM]{2}\/\d{4}$/', Rule::unique('doctors')],
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('doctors')],
            'phone' => 'required',
            'degree' => 'required',
            'specialization' => 'required',
            'hospital' => 'required',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'polyName' => 'required',
            'polyclinic_id' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);


        // Check if the validation fails
        if ($validator->fails()) {
            //Log the validation errors
            Log::error('Validation failed: ' . $validator->errors());

            // Redirect back to the form with the errors
            // return redirect()->back()->withErrors($validator)->withInput();
            return redirect()->back()->with('error',  $validator->errors());
        }

        // Generate a unique doctor ID
        $doctorId = $this->generateDoctorId();
        // Check if a file is present in the request
        if ($request->hasFile('photo')) {
            // Store the uploaded file
            $photo = $request->file('photo');
            // $filename = time() . '.' . $photo->getClientOriginalExtension(); // Get the file extension
            $filename = $doctorId . '.' . $photo->getClientOriginalExtension(); // Get the file extension
            // // Log the filename before storing
            // Log::info('Filename before storing: ' . $filename);

            // Store the file in storage
            try {
                $photo->storeAs('public/images',  $filename);
            } catch (\Exception $e) {
                // Log any exception that occurs during file storage
                Log::error('Error storing file: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Failed to upload image.');
            }
        } else {
            $filename = ''; // If no file uploaded, set filename to empty string
        }
        // Log the filename after storing
        Log::info('Filename after storing: ' . $filename);

        // Create a new Doctor instance and store it in the database
        try {
            Doctor::create([
                'doctor_id' => $doctorId,
                'nik' => $request->nik,
                'sip' => $request->sip,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'degree' => $request->degree,
                'specialization' => $request->specialization,
                'hospital' => $request->hospital,
                'address' => $request->address,
                'city' => $request->city,
                'province' => $request->province,
                'zip' => $request->zip,
                'country' => $request->country,
                'polyclinic_id' => $request->polyclinic_id,
                'photo' => $filename,
                'polyName' => $request->polyName,
                'role' => 'doctor',
                'password' =>  Hash::make('password'),

            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            // Log any exception that occurs during Doctor creation
            Log::error('Error creating doctor: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to create doctor.');
        }

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
    }

    // Generate a unique doctor ID that does not exist in the database
    private function generateDoctorId()
    {
        $doctorId = '';
        do {
            // Generate a random doctor ID
            $prefix = 'DCR';
            $randomNumber = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $randomCharacters = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3);
            $doctorId = $prefix . $randomNumber . $randomCharacters;
            // Check if the generated doctor ID already exists in the database
        } while (Doctor::where('doctor_id', $doctorId)->exists());
        return $doctorId;
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



    public function update(Request $request, $doctor_id)
    {
        // Validate the request data
        $request->validate([
            'sip' => ['required', Rule::unique('doctors')->ignore($doctor_id, 'doctor_id')],
            // Add other validation rules for other fields here...
        ]);

        try {
            // Find the doctor by ID
            $doctor = Doctor::where('doctor_id', $doctor_id)->firstOrFail();

            // Check if the email already exists for another user
            $existingUser = Doctor::where('email', $request->email)
                ->where('doctor_id', '!=', $doctor_id) // Exclude the current doctor
                ->exists();

            // If the email already exists for another user, throw an error
            if ($existingUser) {
                throw new \Exception('Email address already exists for another user.');
            }

            // Update the doctor's information
            $doctor->update([
                'sip' => $request->sip,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,

                'hospital' => $request->hospital,
                'address' => $request->address,
                'city' => $request->city,
                'province' => $request->province,
                'zip' => $request->zip,
                'country' => $request->country,

                // Add other fields to update here...
            ]);

            // Handle photo update if a new photo is provided
            if ($request->hasFile('photo')) {
                // Delete old photo if it exists
                if ($doctor->photo) {
                    Storage::delete('public/images/' . $doctor->photo);
                }

                // Store new photo
                $photo = $request->file('photo');
                $filename = $doctor->doctor_id . '.' . $photo->getClientOriginalExtension();

                // Store the file in storage
                $photo->storeAs('public/images', $filename);

                // Update the doctor's photo attribute with the new filename
                $doctor->photo = $filename;
                $doctor->save();
            }

            // Redirect with success message
            return redirect()->route('doctors.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            // Log the error and redirect with error message
            Log::error('Error updating user: ' . $e->getMessage());
            return redirect()->route('doctors.index')->with('error', 'Failed to update user.' . $e->getMessage());
        }
    }


    //edit
    public function edit($id)
    {
        $polyclinics = Polyclinic::all();
        Log::info($polyclinics); // Log the variable
        $doctor = DB::table('doctors')->where('id', $id)->first();
        return view('pages.doctors.edit', compact('doctor', 'polyclinics'));
    }
    //destroy
    public function destroy($id)
    {
        // Find the doctor to be deleted
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return redirect()->route('doctors.index')->with('error', 'Doctor not found.');
        }

        // Check if the photo is a URL
        if (!filter_var($doctor->photo, FILTER_VALIDATE_URL)) {
            // Delete the photo from storage
            Storage::delete('public/images/' . $doctor->photo);
        }

        // Delete the doctor
        $doctor->delete();

        // Get the last maximum ID value
        $maxId = Doctor::max('id');

        // Reset the auto-increment value to the last maximum ID value
        DB::statement('ALTER TABLE doctors AUTO_INCREMENT = ' . ($maxId + 1));

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
