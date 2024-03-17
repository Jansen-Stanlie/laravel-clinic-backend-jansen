@extends('layouts.app')

@section('title', 'Create User')

@push('style')
    <!-- CSS Libraries -->
    <!-- CSS Libraries -->
    <style>
        .image-container {
            position: relative;
            display: inline-block;
        }

        .delete-image-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 1;
            /* Ensure the button is on top of the image */
        }
    </style>
    <link rel="stylesheet" href="{{ asset('library/dropzone/dist/dropzone.css') }}">
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
                <h1>Doctor Forms</h1>
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
                    <form id="doctorForm" action="{{ route('doctors.update', $doctor->doctor_id) }}" method="POST"
                        class="needs-validation" novalidate="" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h4>Edit Data</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input type="readonly" class="form-control @error('nik') is-invalid @enderror"
                                            required="" name="nik" pattern="[0-9]+" value="{{ $doctor->nik }}"
                                            readonly>

                                        @error('nik')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="invalid-feedback">
                                            Please fill in your NIK with numbers only.
                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" class="form-control" name="doctor_id"
                                    value="{{ $doctor->doctor_id }}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>SIP</label>
                                        <input type="text" class="form-control @error('sip') is-invalid @enderror"
                                            required name="sip" value="{{ $doctor->sip }}">
                                        @error('sip')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="invalid-feedback">
                                            please fill in your SIP Number
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            required="" name="name" value="{{ $doctor->name }}">
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
                                            required="" name="email" value="{{ $doctor->email }}">
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" required name='address'
                                            value="{{ $doctor->address }}">

                                        <div class="invalid-feedback">
                                            please fill in your address
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Hospital</label>
                                        <input type="text" class="form-control" required name='hospital'
                                            value="{{ $doctor->hospital }}">

                                        <div class="invalid-feedback">
                                            please fill in your hospital
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Province</label>
                                        <input type="text" class="form-control" required name='province'
                                            value="{{ $doctor->province }}">

                                        <div class="invalid-feedback">
                                            please fill in your province
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text" class="form-control" required name='city'
                                            value="{{ $doctor->city }}">

                                        <div class="invalid-feedback">
                                            please fill in your city
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- New field for country -->
                            <div class="row mb-n3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country</label>
                                        <input type="text" class="form-control" required name="country" readonly
                                            value="{{ $doctor->country }}">
                                        <div class="invalid-feedback">Please fill in your country</div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-0">
                                    <div class="form-group">
                                        <label>Zip Code</label>
                                        <input type="text" class="form-control @error('zip') is-invalid @enderror"
                                            required name='zip' value="{{ $doctor->zip }}">
                                        @error('zip')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="invalid-feedback">Please Input Your Zip Code</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                            required name='phone' value="{{ $doctor->phone }}">
                                        {{-- pattern="[0-9]{10,14}" --}}
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <div class="invalid-feedback">Please Input Your Phone Number</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-lock"></i>
                                            </div>
                                        </div>
                                        <input type="password" readonly
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
                                    <div class="invalid-feedback">Please Input Your Password</div>
                                </div>
                            </div>
                            <div class="row mb-2 mt-2 mt-lg-n2"> <!-- Modified class mt-2 added here -->
                                <div class="col-12">
                                    <input type="hidden" name="oldphoto" value="{{ $doctor->photo }}">
                                    <label for="imageInput">Doctor Image</label>
                                    <div class="custom-file">
                                        <input type="file" name="photo" id="imageInput" accept="image/*"
                                            class="custom-file-input">
                                        <label class="custom-file-label" id="selectedImageLabel" for="imageInput">Choose
                                            file</label>
                                        <div class="invalid-feedback mt-2">
                                            Please select an image.
                                        </div>
                                    </div>
                                    <div class="row mb-2 mt-2">
                                        <!-- Display Existing Image (Old Photo) -->
                                        <div class="col-md-6">
                                            <label for="existingImage">Old Photo</label>
                                            <div id="existingImageContainer" class="mt-1" name="oldphoto">
                                                <div class="image-container position-relative">
                                                    @if ($doctor->photo && preg_match('/\bhttps?:\/\/\S+\b/', $doctor->photo))
                                                        <img class="mb-2" src="{{ $doctor->photo }}"
                                                            alt="Existing Image" id="existingImage" class="img-fluid"
                                                            style="max-width: 200px;">
                                                    @else
                                                        <img class="mb-2"
                                                            src="{{ asset('storage/images/' . $doctor->photo) }}"
                                                            alt="Existing Image" id="existingImage" class="img-fluid"
                                                            style="max-width: 200px;">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Display Newly Selected Image (New Photo) -->
                                        <div class="col-md-6">
                                            <label id="newPhotoLabel" style="display: none;" for="importedImage">New
                                                Photo</label>
                                            <div id="importedImageContainer" style="display: none;" class="mt-1">
                                                <div class="image-container position-relative">
                                                    <img class="mb-2" src="" alt="Imported Image"
                                                        id="importedImage" class="img-fluid" style="max-width: 200px;">
                                                    <button id="removeImageButton"
                                                        class="btn btn-danger delete-image-btn">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback mt-2">
                                        Please select an image.
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="form-label">Polyclinics</label>
                                <select id="polyclinic" class="form-control @error('polyclinic') is-invalid @enderror"
                                    required disabled>
                                    <option value="" selected>{{ $doctor->polyName }}</option>
                                    @foreach ($polyclinics as $polyclinic)
                                        <option value="{{ $polyclinic->id }}"
                                            data-poly-name="{{ $polyclinic->polyName }}"
                                            data-poly-id="{{ $polyclinic->polyID }}"
                                            degree="{{ $polyclinic->degree_requirement }}"
                                            specialization="{{ $polyclinic->specialization }}"
                                            description="{{ $polyclinic->description }}">
                                            <!-- Set text color to black -->
                                            {{ $polyclinic->polyName }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('polyclinic')
                                    <div class="invalid-feedback" style="display: block;">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="invalid-feedback">Please Select your poly</div>
                            </div>
                            <!-- Hidden input fields for polyName and polyId -->
                            {{-- <input type="hidden" name="polyName" id="polyName"> --}}
                            <input type="hidden" name="polyclinic_id" id="polyclinic_id">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Degree Requirement</label>
                                        <input type="text"
                                            class="form-control @error('degree_requirement') is-invalid @enderror"
                                            id="degree_requirement" name="degree" readonly
                                            value="{{ $doctor->degree }}">
                                        @error('degree_requirement')
                                            <div class="invalid-feedback" style="display: block;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Specialization Field -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Specialization</label>
                                        <input type="text"
                                            class="form-control @error('specialization') is-invalid @enderror"
                                            id="specialization" name="specialization" readonly required
                                            value="{{ $doctor->specialization }}">
                                        @error('specialization')
                                            <div class="invalid-feedback" style="display: block;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- polyclinic_id Field -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Polyclinic id</label>
                                        <input class="form-control @error('polyclinic_id') is-invalid @enderror"
                                            id="polyclinic_id" name="polyclinic_id" readonly required
                                            value="{{ $doctor->polyclinic_id }}">
                                        @error('polyclinic_id')
                                            <div class="invalid-feedback" style="display: block;">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Update</button>
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

        document.getElementById('polyclinic').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById('degree_requirement').value = selectedOption.getAttribute('degree');
            document.getElementById('specialization').value = selectedOption.getAttribute('specialization');
            document.getElementById('description').value = selectedOption.getAttribute('description');
            // Set the values of hidden input fields for polyName and polyId
            document.getElementById('polyName').value = selectedOption.getAttribute('data-poly-name');
            document.getElementById('polyclinic_id').value = selectedOption.getAttribute('data-poly-id');
        });
    </script>
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('https://ipapi.co/json/')
                .then(response => response.json())
                .then(data => {
                    // Retrieve the location details from the geolocation data
                    document.querySelector('input[name="country"]').value = data.country_name;
                    document.querySelector('input[name="province"]').value = data.region;
                    document.querySelector('input[name="city"]').value = data.city;
                    document.querySelector('input[name="zip"]').value = data.postal;
                })
                .catch(error => {
                    // If an error occurs or if the service is unavailable, default to Indonesia
                    document.querySelector('input[name="country"]').value = "Indonesia";
                    document.querySelector('input[name="province"]').value = "No Data";
                    document.querySelector('input[name="city"]').value = "No Data";
                    document.querySelector('input[name="zip"]').value = "No Data";
                });
        });
    </script> --}}
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    // Retrieve the country based on the user's location coordinates
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;

                    // Use a reverse geocoding service to get the country
                    // This is a simplified example, you should use a proper reverse geocoding API
                    // For demonstration purposes, defaulting to Indonesia
                    document.querySelector('input[name="country"]').value = "Indonesia";
                }, function(error) {
                    // If geolocation fails, default to Indonesia
                    document.querySelector('input[name="country"]').value = "Indonesia";
                });
                console.log("Geolocation is not supported by this browser.", navigator);
            } else {
                console.log("Geolocation is not supported by this browser.", navigator);
                // If geolocation is not supported, default to Indonesia
                document.querySelector('input[name="country"]').value = "Indonesia";
            }
        });
    </script> --}}
    <script>
        // Event listener for file input change
        document.getElementById('imageInput').addEventListener('change', function() {
            var file = this.files[0];
            if (file) {
                // Display the selected image name
                document.getElementById('selectedImageLabel').innerText = file.name;
                displayImage(file);
                // Display the label for new photo
                document.getElementById('newPhotoLabel').style.display = 'block';
            }
        });

        // Function to display the selected image
        function displayImage(file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('importedImage').src = e.target.result;
                document.getElementById('importedImageContainer').style.display = 'block';
            }
            reader.readAsDataURL(file);
        }

        // Event listener for remove image button
        document.getElementById('removeImageButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action of the button click
            // Remove the image
            document.getElementById('importedImage').src = '';
            document.getElementById('importedImageContainer').style.display = 'none';
            // Reset the file input
            document.getElementById('imageInput').value = '';
            // Reset the selected image label to "Choose file"
            document.getElementById('selectedImageLabel').innerText = 'Choose file';
            // Hide the label for new photo
            document.getElementById('newPhotoLabel').style.display = 'none';
        });
    </script>
    <script>
        document.getElementById('imageInput').addEventListener('change', function() {
            var file = this.files[0];
            if (!file) {
                document.getElementById('imageError').style.display = 'block';
            } else {
                document.getElementById('imageError').style.display = 'none';
            }
        });
    </script>
@endpush
