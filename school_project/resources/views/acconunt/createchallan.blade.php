@extends('layouts.front')

@section('content')
<div class="dashboard-content-one">
    <!-- Breadcrumbs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Challan Management</h3>
        <ul>
            <li>
                <a href="index.html">Home</a>
            </li>
            <li>Create Challan</li>
        </ul>
    </div>
    <!-- Breadcrumbs Area End Here -->
    <!-- Create Challan Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Create New Challan</h3>
                </div>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">...</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('create-challan') }}"><i class="fas fa-times text-orange-red"></i>Close</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                        <a class="dropdown-item" href="{{ route('create-challan') }}"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                    </div>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <!-- Challan Form -->
            <form action="{{ route('create-challan.store') }}" method="POST" class="mg-b-20">
                @csrf
                <div class="row gutters-8">
                    <!-- School Name -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="school_name" class="form-label">School Name</label>
                        <input type="text" name="school_name" id="school_name" class="form-control" required>
                    </div>
                    <!-- School Branch -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="school_branch" class="form-label">School Branch</label>
                        <input type="text" name="school_branch" id="school_branch" class="form-control" required>
                    </div>
                    <!-- Class Dropdown -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="class" class="form-label">Class</label>
                        <select name="class" id="class" class="form-control" required>
                            <option value="" disabled selected>Select Class</option>
                            @foreach(['ECE', 'Prep', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten'] as $class)
                                <option value="{{ $class }}">{{ $class }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Section Dropdown -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="section" class="form-label">Section</label>
                        <select name="section" id="section" class="form-control" required>
                            <option value="" disabled selected>Select Section</option>
                            @foreach(['Pink', 'Green', 'Red', 'Orange', 'Blue', 'Silver', 'Yellow'] as $section)
                                <option value="{{ $section }}">{{ $section }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- How Many Months -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="months" class="form-label">How Many Months</label>
                        <input type="number" name="months" id="months" class="form-control" min="1" required>
                    </div>
                    <!-- How Many Students -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="students" class="form-label">How Many Students</label>
                        <input type="number" name="students" id="students" class="form-control" min="1" required>
                    </div>
                    <!-- Student Name -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="student_name" class="form-label">Student Name</label>
                        <input type="text" name="student_name" id="student_name" class="form-control" required>
                    </div>
                    <!-- Roll Number -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="roll_number" class="form-label">Roll Number</label>
                        <input type="text" name="roll_number" id="roll_number" class="form-control" required>
                    </div>
                    <!-- Academic Session Dropdown -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="academic_session" class="form-label">Academic Year</label>
                        <select name="academic_session" id="academic_session" class="form-control" required>
                            <option value="" disabled selected>Select Academic Year</option>
                            @for($year = 2020; $year <= 2030; $year++)
                                <option value="{{ $year }}-{{ $year + 1 }}">{{ $year }}-{{ $year + 1 }}</option>
                            @endfor
                        </select>
                    </div>
                    <!-- Year Dropdown -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="year" class="form-label">Year</label>
                        <select name="year" id="year" class="form-control" required>
                            <option value="" disabled selected>Select Year</option>
                            @for($year = 2020; $year <= 2030; $year++)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <!-- Create Challan Button -->
                <div class="row gutters-8">
                    <div class="col-12 form-group">
                        <button type="submit" class="fw-btn-fill btn-gradient-yellow btn-lg">Create Challan</button>
                    </div>
                </div>
            </form>
            <hr class="my-4">
            <!-- Fee List as per Classes -->
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Fee List as per Classes</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Academic Session</th>
                            <th>Year</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Fee</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($challans as $challan)
                            <tr>
                                <td>{{ $challan->academic_session }}</td>
                                <td>{{ $challan->year }}</td>
                                <td>{{ $challan->class }}</td>
                                <td>{{ $challan->section }}</td>
                                <td>{{ number_format($challan->total_fee, 2) }}</td>
                                <td>{{ ucfirst($challan->status) }}</td>
                                <td>
                                    <a href="{{ route('view-challan', $challan->id) }}" class="btn btn-lg btn-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No challans created yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Challan Area End Here -->
</div>
@endsection