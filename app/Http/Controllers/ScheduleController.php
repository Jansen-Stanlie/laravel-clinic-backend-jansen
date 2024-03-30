<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Polyclinic;
use App\Models\Doctor;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    //index
    public function index(Request $request)
    {
        // Initialize the query
        $query = DB::table('schedules');

        // Filter by doctor name
        if ($request->has('name')) {
            $query->where('doctor_name', 'like', '%' . $request->input('name') . '%');
        }

        // Filter by weekdays if not null
        if ($request->has('weekday') && $request->input('weekday') !== null) {
            $query->where('day', $request->input('weekday'));
        }

        // Filter by date range
        if ($request->has('date_range')) {
            $dates = explode(' - ', $request->input('date_range'));
            $start_date = date('Y-m-d', strtotime($dates[0])); // Convert start date to Y-m-d format
            $end_date = date('Y-m-d', strtotime($dates[1])); // Convert end date to Y-m-d format
            $query->whereBetween('date_schedule', [$start_date, $end_date]);
        }

        // Filter by status if not null
        if ($request->has('status') && $request->input('status') !== null) {
            $query->where('status', 'like', '%' . $request->input('status') . '%');
        }

        // Order by updated_at
        $query->orderBy('date_schedule', 'asc');

        // Paginate the results
        $schedules = $query->paginate(10);

        return view('pages.schedules.index', compact('schedules'));
    }


    //create
    public function create()
    {
        $doctors = DB::table('doctors')->get();
        $polyclinics = Polyclinic::all();
        return view('pages.schedules.create', compact('doctors', 'polyclinics'));
    }

    //show
    public function show($id)
    {
        $schedule = Schedule::findOrFail($id);
        return view('pages.schedules.show', compact('schedule'));
    }

    //edit
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $doctors = Doctor::all();
        $polyclinics = Polyclinic::all();
        return view('pages.schedules.edit', compact('schedule', 'doctors', 'polyclinics'));
    }

    //update
    public function update(Request $request, $id)
    {
        // Find the schedule by its ID
        $schedule = Schedule::findOrFail($id);

        // Parse form data
        $startTime = $request->input('start');
        $endTime = $request->input('end');

        // Separate hours and minutes from start time
        list($startTimeHour, $startTimeMinute) = explode(':', $startTime);

        // Separate hours and minutes from end time
        list($endTimeHour, $endTimeMinute) = explode(':', $endTime);

        if ($schedule) {
            // Update the schedule entry
            $schedule->update([
                'start' => sprintf('%02d:%02d:00', $startTimeHour, $startTimeMinute),
                'end' => sprintf('%02d:%02d:00', $endTimeHour, $endTimeMinute),
                'status' => $request->input('status'),
            ]);

            // Redirect to a success page
            return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
        } else {
            // Redirect back with an error message
            return redirect()->back()->withInput()->with('error', 'Schedule not found. Please select a valid doctor.');
        }
    }

    //store
    public function store(Request $request)
    {
        // Parse form data
        $doctorId = $request->input('doctor_id');
        $dateRange = explode(' - ', $request->input('date_range'));

        // Find doctor details
        $doctor = Doctor::where('doctor_id', $doctorId)->first();

        if ($doctor) {
            // Extract start and end dates from the date range
            $startDate = new \DateTime($dateRange[0]);
            $endDate = new \DateTime($dateRange[1]);

            // Loop through each day between start and end dates
            $interval = new \DateInterval('P1D');
            $dateRange = new \DatePeriod($startDate, $interval, $endDate);

            foreach ($dateRange as $date) {
                $dateSchedule = $date->format('Y-m-d'); // Format date as Y-m-d
                $dayName = $date->format('l'); // Get day name

                // Extract start and end times for the current day from the form data
                $startTime = $request->input(strtolower($dayName) . '_start');
                $endTime = $request->input(strtolower($dayName) . '_end');

                // Format the start and end times
                $startTimeParts = explode(':', $startTime);
                $endTimeParts = explode(':', $endTime);
                $startTimeHour = $startTimeParts[0];
                $startTimeMinute = $startTimeParts[1];
                $endTimeHour = $endTimeParts[0];
                $endTimeMinute = $endTimeParts[1];

                // Create or update the schedule entry
                Schedule::updateOrCreate(
                    [
                        'doctor_id' => $doctor->doctor_id,
                        'date_schedule' => $dateSchedule,
                        'day' => $dayName,
                    ],
                    [
                        'doctor_name' => $doctor->name,
                        'polyclinic_id' => $doctor->polyclinic_id,
                        'specialization' => $doctor->specialization,
                        'start' => sprintf('%02d:%02d:00', $startTimeHour, $startTimeMinute),
                        'end' => sprintf('%02d:%02d:00', $endTimeHour, $endTimeMinute),
                        'status' => 'available', // Assuming status is always 'available' for newly created schedules
                    ]
                );
            }

            // Redirect to a success page
            return redirect()->route('schedules.index')->with('success', 'Schedule added successfully.');
        } else {
            // Redirect back with an error message
            return redirect()->back()->withInput()->with('error', 'Doctor not found. Please select a valid doctor.');
        }
    }
    public function destroy($id)
    {
        // Find the schedule by its ID
        $schedule = Schedule::findOrFail($id);

        // Delete the schedule
        $schedule->delete();

        // Redirect back to the index page with a success message
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
