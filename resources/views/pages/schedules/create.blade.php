@extends('layouts.app')

@section('title', 'Add Schedule')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Add Schedule</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}">Dashboard</a>
                    </div>
                    <div class="breadcrumb-item {{ request()->routeIs('schedules.*') ? 'active' : '' }}">
                        <a href="{{ route('schedules.index') }}">Doctor Schedule</a>
                    </div>
                    <div class="breadcrumb-item">All Schedule</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Doctors Schedules</h2>
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="card">
                    <form id="scheduleForm" action="{{ route('schedules.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body mb-n20">
                                    <div class="form-group">
                                        <label for="doctor">Doctor</label>
                                        <select id="doctor" name="doctor_id" class="form-control select2" required>
                                            <option value="">Select Doctor</option>
                                            @foreach ($doctors as $doctor)
                                                <option value="{{ $doctor->doctor_id }}">{{ $doctor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body mt-n20">
                                    <label for="date_range">Tanggal Schedule Doctor</label>
                                    <input type="text" id="date_range" name="date_range"
                                        class="form-control daterange-cus" required>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <label for="weekly_schedule">Weekly Schedule Doctor</label>
                            <table id="weekly_schedule_table" class="table">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Rows for weekdays will be dynamically generated here -->
                                </tbody>
                            </table>
                        </div>

                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>
            </div>
    </div>
    </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/bootstrap-daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Get today's date
            var today = moment();
            // Calculate the date one month from today
            var oneMonthLater = today.clone().add(1, 'month');
            // Calculate the date one week from today
            var nextWeek = today.clone().add(7, 'days');
            // Calculate the date one year from today
            var nextYear = today.clone().add(1, 'year');
            // Calculate the date two years from today
            var twoYearsLater = today.clone().add(2, 'years');
            // Calculate the end date for "Today" range (next 1 month)
            var nextMonth = today.clone().add(1, 'month');
            // Initialize date range picker
            $('#date_range').daterangepicker({
                opens: 'left',
                showDropdowns: false, // Disable dropdowns for year and month
                startDate: today, // Set start date to today
                endDate: oneMonthLater, // Set end date to one month later
                minDate: today, // Set minimum date to today
                // minMonth: today.month(), // Set minimum month to the current month
                // maxMonth: 11, // Set maximum month to December (index 11)
                // minYear: today.year(), // Set minimum year to the current year
                // maxYear: twoYearsLater.year(), // Set maximum year to two years from the current year
                locale: {
                    format: 'YYYY-MM-DD',
                    applyLabel: 'Apply', // Label for the apply button
                    cancelLabel: 'Cancel', // Label for the cancel button
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr',
                        'Sa'
                    ], // Custom days of the week labels
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December'
                    ], // Custom month names
                },
                ranges: {
                    'Next 1 Month': [moment(), nextMonth], // Next 1 month range
                    'Next 7 Days': [moment(), nextWeek], // Next 7 days range
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Next 1 Year': [moment(), nextYear], // Next 1 year range
                },
                showCustomRangeLabel: false, // Hide the "Custom Range" option
                alwaysShowCalendars: true, // Always show the calendars
                showTodayButton: true, // Show the "Today" button
                showClearButton: true, // Show the "Clear" button
                autoApply: true, // Apply the selected date range automatically when clicking outside the date picker
                // Custom input for date range
                // autoUpdateInput: false, // Disable auto-update of input fields
                // forceUpdate: true, // Force update input fields
                opens: 'left', // Set calendar to open on the left side of input
            });

            // Generate weekly schedule rows
            generateWeekdayRows();


            function generateWeekdayRows() {
                var tableBody = $('#weekly_schedule_table tbody');
                tableBody.empty(); // Clear existing rows

                // Array of weekdays
                var weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

                // Loop through each weekday
                for (var i = 0; i < 7; i++) {
                    var dayName = weekdays[i];
                    var dayInput = '<input type="time" class="form-control start-time" name="' + dayName
                        .toLowerCase() +
                        '_start" id="' + dayName.toLowerCase() + '_start" required>';
                    var endInput = '<input type="time" class="form-control end-time" name="' + dayName
                        .toLowerCase() +
                        '_end" id="' + dayName.toLowerCase() + '_end" required>';
                    var newRow = '<tr>' +
                        '<td>' + dayName + '</td>' +
                        '<td><label for="' + dayName.toLowerCase() + '_start">Start Time</label>' + dayInput +
                        '</td>' +
                        '<td><label for="' + dayName.toLowerCase() + '_end">End Time</label>' + endInput + '</td>' +
                        '</tr>';

                    tableBody.append(newRow);
                }

                // Set default end time to 8 hours after start time
                $('.start-time').change(function() {
                    var startTime = $(this).val();
                    var endTimeInput = $(this).closest('tr').find('.end-time');
                    var defaultEndTime = moment(startTime, 'HH:mm').add(8, 'hours').format('HH:mm');
                    endTimeInput.val(defaultEndTime);
                });
            }
        });
    </script>

    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
@endpush
