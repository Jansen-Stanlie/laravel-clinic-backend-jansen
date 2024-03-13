@extends('layouts.app')

@section('title', 'Doctors')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Doctor</h1>
                <div class="section-header-button">
                    <a href="{{ route('doctors.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Doctor</a></div>
                    <div class="breadcrumb-item">All Doctor</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <h2 class="section-title">Doctors</h2>
                <p class="section-lead">
                    You can manage all Users, such as editing, deleting and more.
                </p>


                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Posts</h4>
                            </div>
                            <div class="card-body">

                                <div class="float-right">
                                    <form method="GET" action="{{ route('doctors.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Degree</th>
                                            <th>Phone</th>
                                            <th>Specialist</th>
                                            <th>Status</th>
                                            <th>Hospital</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($doctors as $doctor)
                                            <tr>
                                                <td>
                                                    <img alt="image" src="{{ $doctor->photo }}" class="rounded-square"
                                                        width="35" height="35" data-toggle="title"
                                                        title="{{ $doctor->name }}">
                                                </td>
                                                <td>{{ $doctor->name }}
                                                </td>
                                                <td>
                                                    {{ $doctor->email }}
                                                </td>
                                                <td>
                                                    {{ $doctor->degree }}
                                                </td>
                                                <td>
                                                    {{ $doctor->phone }}
                                                </td>
                                                <td>
                                                    {{ $doctor->specialization }}
                                                </td>
                                                <td>
                                                    @if ($doctor->status == 'Active')
                                                        <div class="badge badge-success">{{ $doctor->status }}</div>
                                                    @else
                                                        <div class="badge badge-danger">{{ $doctor->status }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($doctor->hospital)
                                                        {{ $doctor->hospital }}
                                                    @else
                                                        <div class="badge badge-danger">No Hospital</div>
                                                    @endif
                                                </td>
                                                <td>{{ $doctor->created_at }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('doctors.edit', $doctor->id) }}'
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </a>

                                                        <form action="{{ route('doctors.destroy', $doctor->id) }}"
                                                            method="POST" class="ml-2">
                                                            <input type="hidden" name="_method" value="DELETE" />
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}" />
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
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
                                                        @if ($doctors->currentPage() > 1)
                                                            <li class="page-item">
                                                                <a class="page-link"
                                                                    href="{{ $doctors->url(1) }}">First</a>
                                                            </li>
                                                            <li class="page-item">
                                                                <a class="page-link"
                                                                    href="{{ $doctors->previousPageUrl() }}">Previous</a>
                                                            </li>
                                                        @endif
                                                        <!-- Pagination links -->
                                                        @for ($i = 1; $i <= $doctors->lastPage(); $i++)
                                                            @if ($i == $doctors->currentPage())
                                                                <li class="page-item active">
                                                                    <span class="page-link">{{ $i }}</span>
                                                                </li>
                                                            @elseif ($i >= $doctors->currentPage() - 2 && $i <= $doctors->currentPage() + 2)
                                                                <li class="page-item">
                                                                    <a class="page-link"
                                                                        href="{{ $doctors->url($i) }}">{{ $i }}</a>
                                                                </li>
                                                            @elseif ($i == $doctors->currentPage() - 3 || $i == $doctors->currentPage() + 3)
                                                                <li class="page-item disabled">
                                                                    <span class="page-link">...</span>
                                                                </li>
                                                            @endif
                                                        @endfor
                                                        <!-- Next and Last buttons -->
                                                        @if ($doctors->hasMorePages())
                                                            <li class="page-item">
                                                                <a class="page-link"
                                                                    href="{{ $doctors->nextPageUrl() }}">Next</a>
                                                            </li>
                                                            <li class="page-item">
                                                                <a class="page-link"
                                                                    href="{{ $doctors->url($doctors->lastPage()) }}">Last</a>
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
@endpush
