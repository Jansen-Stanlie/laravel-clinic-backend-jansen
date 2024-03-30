@extends('layouts.app')

@section('title', 'Edit Schedule')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Doctors Schedule</h1>
                <div class="section-header-breadcrumb">
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item {{ request()->routeIs('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}">Dashboard</a>
                        </div>
                        <div class="breadcrumb-item {{ request()->routeIs('schedules.*') ? 'active' : '' }}">
                            <a href="{{ route('schedules.index') }}">Doctor Schedule</a>
                        </div>
                        <div class="breadcrumb-item">Edit Schedule</div>
                    </div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Edit Schedules</h2>
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="card">
                    <form action="{{ route('schedules.update', $schedule) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h4>Edit Data</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" readonly
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ $schedule->doctor_name }}" name="name">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Schedule Date</label>
                                        <input type="text" class="form-control"
                                            value="{{ $schedule->date_schedule . ' - ' . $schedule->day }}" readonly
                                            name="schedule_date">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <input type="time" class="form-control timepicker"
                                                value="{{ $schedule->start }}" name="start">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>End Time</label>
                                            <input type="time" class="form-control timepicker"
                                                value="{{ $schedule->end }}" name="end">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="selectgroup w-100">
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="status" value="available"
                                                        @if ($schedule->status == 'available') checked @endif
                                                        class="selectgroup-input" checked="">
                                                    <span class="selectgroup-button">Available</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="selectgroup w-100">
                                                <label class="selectgroup-item">
                                                    <input type="radio" name="status" value="booked"
                                                        @if ($schedule->status == 'booked') checked @endif
                                                        class="selectgroup-input">
                                                    <span class="selectgroup-button">Booked</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Function to add 8 hours to the start time and update the end time
            $('.timepicker[name="start"]').on('change', function() {
                var startTime = $(this).val(); // Get the value of the start time input
                var startMoment = moment(startTime, 'HH:mm'); // Parse the start time using moment.js
                var endTime = startMoment.add(8, 'hours').format(
                'HH:mm'); // Add 8 hours to the start time and format as HH:mm
                $('.timepicker[name="end"]').val(endTime); // Update the value of the end time input
            });
        });
    </script>
@endpush
