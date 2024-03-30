@extends('layouts.app')

@section('title', 'Doctors Schedules')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Doctor Schedule</h1>
                <div class="section-header-button">
                    <a href="{{ route('schedules.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item {{ request()->routeIs('home') ? 'active' : '' }}">
                        <a href="{{ route('home') }}">Dashboard</a>
                    </div>
                    <div class="breadcrumb-item {{ request()->routeIs('schedules.*') ? 'active' : '' }}">
                        <a href="{{ route('schedules.index') }}">Doctor Schedule</a>
                    </div>
                    <div class="breadcrumb-item">Add Schedule</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Doctors Schedule</h2>
                <p class="section-lead">
                    You can manage doctor schedule, such as editing, deleting and more.
                </p>


                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Posts</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-auto">
                                        <!-- Combined form for search bar and filter inputs -->
                                        <form method="GET" action="{{ route('schedules.index') }}">
                                            <div class="input-group mb-2">
                                                <input type="text" class="form-control" placeholder="Search"
                                                    name="name" value="{{ request()->input('name') }}">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>

                                            <div class="form-row align-items-center">
                                                <div class="col-md-auto mb-2">
                                                    <select class="form-control" name="weekday">
                                                        <option value="">Select Weekday</option>
                                                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                            <option value="{{ $day }}"
                                                                {{ request()->input('weekday') == $day ? 'selected' : '' }}>
                                                                {{ $day }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <input type="text" id="date_range" name="date_range"
                                                        class="form-control daterange-cus"
                                                        placeholder="YYYY-MM-DD - YYYY-MM-DD"
                                                        value="{{ request()->input('date_range') }}">
                                                </div>
                                                <div class="col-md-auto mb-2">
                                                    <select class="form-control" name="status">
                                                        <option value="">Select Status</option>
                                                        <option value="available"
                                                            {{ request()->input('status') == 'available' ? 'selected' : '' }}>
                                                            available</option>
                                                        <option value="booked"
                                                            {{ request()->input('status') == 'booked' ? 'selected' : '' }}>
                                                            booked</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-auto mb-2">
                                                    <button type="submit" class="btn btn-primary btn-block">Apply
                                                        Filters</button>
                                                </div>
                                                <div class="col-md-auto mb-2">
                                                    <a href="{{ route('schedules.index') }}"
                                                        class="btn btn-secondary btn-block">Reset</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="clearfix mb-3"></div>

                                    <div class="table-responsive">
                                        <table class="table-striped table">
                                            <tr>
                                                <th>Doctor ID</th>
                                                <th>Doctor Name</th>
                                                <th>Specialization</th>
                                                <th>Schedule Date </th>
                                                <th>Schedule Time</th>
                                                <th>Day of the Week</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            @foreach ($schedules as $schedule)
                                                <tr>
                                                    <td title="{{ $schedule->doctor_id }}">{{ $schedule->doctor_id }}</td>
                                                    <td title="{{ $schedule->doctor_name }}">{{ $schedule->doctor_name }}
                                                    </td>
                                                    <td title="{{ $schedule->specialization }}">
                                                        {{ $schedule->specialization }}</td>
                                                    <td title="{{ $schedule->date_schedule }}">
                                                        {{ $schedule->date_schedule }}
                                                    </td>
                                                    <td title="{{ $schedule->start }} - {{ $schedule->end }}">
                                                        {{ $schedule->start }} - {{ $schedule->end }}
                                                    </td>
                                                    <td title="{{ $schedule->day }}">{{ $schedule->day }}</td>
                                                    <td title="{{ $schedule->status }}">
                                                        @if ($schedule->status == 'available')
                                                            <span
                                                                class="badge badge-success">{{ $schedule->status }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ $schedule->status }}</span>
                                                        @endif

                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a href='{{ route('schedules.edit', $schedule->id) }}'
                                                                class="btn btn-sm btn-info btn-icon">
                                                                <i class="fas fa-edit"></i>
                                                                Edit
                                                            </a>

                                                            <form action="{{ route('schedules.destroy', $schedule->id) }}"
                                                                method="POST" class="ml-2">
                                                                <input type="hidden" name="_method" value="DELETE" />
                                                                <input type="hidden" name="_token"
                                                                    value="{{ csrf_token() }}" />
                                                                <button
                                                                    class="btn btn-sm btn-danger btn-icon confirm-delete"
                                                                    disabled>
                                                                    <i class="fas fa-times"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </table>
                                    </div>
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-center mt-3">
                                                    <nav aria-label="Page navigation">
                                                        <!-- Pagination links -->
                                                        <ul class="pagination justify-content-center flex-wrap">
                                                            <!-- First and Previous buttons -->
                                                            @if ($schedules->currentPage() > 1)
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                        href="{{ $schedules->appends(request()->query())->url(1) }}">First</a>
                                                                </li>
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                        href="{{ $schedules->appends(request()->query())->previousPageUrl() }}">Previous</a>
                                                                </li>
                                                            @endif
                                                            <!-- Pagination links -->
                                                            @for ($i = 1; $i <= $schedules->lastPage(); $i++)
                                                                @if ($i == $schedules->currentPage())
                                                                    <li class="page-item active">
                                                                        <span class="page-link">{{ $i }}</span>
                                                                    </li>
                                                                @elseif ($i >= $schedules->currentPage() - 2 && $i <= $schedules->currentPage() + 2)
                                                                    <li class="page-item">
                                                                        <a class="page-link"
                                                                            href="{{ $schedules->appends(request()->query())->url($i) }}">{{ $i }}</a>
                                                                    </li>
                                                                @elseif ($i == $schedules->currentPage() - 3 || $i == $schedules->currentPage() + 3)
                                                                    <li class="page-item disabled">
                                                                        <span class="page-link">...</span>
                                                                    </li>
                                                                @endif
                                                            @endfor
                                                            <!-- Next and Last buttons -->
                                                            @if ($schedules->hasMorePages())
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                        href="{{ $schedules->appends(request()->query())->nextPageUrl() }}">Next</a>
                                                                </li>
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                        href="{{ $schedules->appends(request()->query())->url($schedules->lastPage()) }}">Last</a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </nav>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>


    <!-- Include NiceScroll plugin -->

    <script>
        $(document).ready(function() {
            // Add click event listener to table cells
            $('td').click(function() {
                // Get cell content

                var content = $(this).attr('title');

                // Create a temporary input element
                var tempInput = $('<input>');
                $('body').append(tempInput);
                tempInput.val(content).select();

                // Copy the content to the clipboard
                document.execCommand('copy');

                // Remove the temporary input element
                tempInput.remove();

                // Show a message indicating that the content has been copied
                // alert('Copied: ' + content);
            });
        });
    </script>
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
            // Calculate the date 10 years from today
            var tenYearsLater = today.clone().add(10, 'years');

            // Initialize date range picker
            $('#date_range').daterangepicker({
                opens: 'left',
                showDropdowns: false,
                // startDate: today,
                // endDate: tenYearsLater,
                locale: {
                    format: 'YYYY-MM-DD',
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December'
                    ],
                },
                ranges: {
                    'Next 1 Month': [moment(), moment().add(1, 'month')],
                    'Next 7 Days': [moment(), moment().add(7, 'days')],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Next 1 Year': [moment(), moment().add(1, 'year')],
                },
                showCustomRangeLabel: false,
                alwaysShowCalendars: true,
                showTodayButton: true,
                showClearButton: true,
                autoApply: true,

            });
        });
    </script>
    </script>
@endpush
