@extends('layouts.app')

@section('title', 'Create User')

@push('style')
    <!-- CSS Libraries -->
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
                <h1>User Forms</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/home">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="/doctors">Doctors</a></div>
                    <div class="breadcrumb-item">Forms</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Doctors</h2>
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="card">
                    <form action="{{ route('users.store') }}" method="POST" class="needs-validation" novalidate="">
                        @csrf
                        <div class="card-header">
                            <h4>Input Data</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            name="email">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label>Address</label>
                                    <input type="text" class="form-control" required="">

                                    <div class="invalid-feedback">
                                        please fill in your address
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    <input type="password"
                                        class="form-control @error('password')
                                is-invalid
                            @enderror"
                                        name="password">
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Polyclinics</label>
                                <select id="polyclinic" class="form-control ">
                                    <option value="">Select Polyclinic</option>
                                    @foreach ($polyclinics as $polyclinic)
                                        <option value="{{ $polyclinic->id }}"
                                            data-degree="{{ $polyclinic->degree_requirement }}"
                                            data-specialization="{{ $polyclinic->specialization }}"
                                            data-description="{{ $polyclinic->description }}" style="color: black;">
                                            <!-- Set text color to black -->
                                            {{ $polyclinic->polyName }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Degree Requirement</label>
                                            <input type="text"
                                                class="form-control @error('degree_requirement') is-invalid @enderror"
                                                id="degree_requirement" name="degree_requirement" readonly required>
                                            @error('degree_requirement')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Specialization Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Specialization</label>
                                            <input type="text"
                                                class="form-control @error('specialization') is-invalid @enderror"
                                                id="specialization" name="specialization" readonly required>
                                            @error('specialization')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Description Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                                rows="3" readonly required></textarea>
                                            @error('description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
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
        document.addEventListener("DOMContentLoaded", function() {
            var options = document.querySelectorAll('#polyclinic option');
            options.forEach(function(option) {
                option.style.color = 'black'; // Set text color to black
            });
        });
    </script>
    <script>
        document.getElementById('polyclinic').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById('degree_requirement').value = selectedOption.getAttribute('data-degree');
            document.getElementById('specialization').value = selectedOption.getAttribute('data-specialization');
            document.getElementById('description').value = selectedOption.getAttribute('data-description');
        });
    </script>
@endpush
