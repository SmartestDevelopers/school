@extends('layouts.front')

@section('content')
<div class="dashboard-content-one">
    <!-- Breadcrumbs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Fee Management</h3>
        <ul>
            <li>
                <a href="index.html">Home</a>
            </li>
            <li>Manage Fees</li>
        </ul>
    </div>
    <!-- Breadcrumbs Area End Here -->
    <!-- Fee Management Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>{{ isset($editFee) ? 'Edit Fee' : 'Add New Fee' }}</h3>
                </div>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">...</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('fee-management') }}"><i class="fas fa-times text-orange-red"></i>Close</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                        <a class="dropdown-item" href="{{ route('fee-management') }}"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                    </div>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <!-- Fee Form -->
            <form action="{{ isset($editFee) ? route('fee-management.update', $editFee->id) : route('fee-management.store') }}" method="POST" class="mg-b-20">
                @csrf
                <div class="row gutters-8">
                    <!-- Class Dropdown -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="class" class="form-label">Class</label>
                        <select name="class" id="class" class="form-control" required>
                            <option value="" disabled {{ !isset($editFee) ? 'selected' : '' }}>Select Class</option>
                            @foreach(['ECE', 'Prep', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten'] as $class)
                                <option value="{{ $class }}" {{ isset($editFee) && $editFee->class == $class ? 'selected' : '' }}>{{ $class }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Section Dropdown -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="section" class="form-label">Section</label>
                        <select name="section" id="section" class="form-control" required>
                            <option value="" disabled {{ !isset($editFee) ? 'selected' : '' }}>Select Section</option>
                            @foreach(['Pink', 'Green', 'Red', 'Orange', 'Blue', 'Silver', 'Yellow', 'Lime'] as $section)
                                <option value="{{ $section }}" {{ isset($editFee) && $editFee->section == $section ? 'selected' : '' }}>{{ $section }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Month Dropdown -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="month" class="form-label">Month</label>
                        <select name="month" id="month" class="form-control" required>
                            <option value="" disabled {{ !isset($editFee) ? 'selected' : '' }}>Select Month</option>
                            @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                <option value="{{ $month }}" {{ isset($editFee) && $editFee->month == $month ? 'selected' : '' }}>{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Year Dropdown -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="year" class="form-label">Year</label>
                        <select name="year" id="year" class="form-control" required>
                            <option value="" disabled {{ !isset($editFee) ? 'selected' : '' }}>Select Year</option>
                            @for($year = 2020; $year <= 2030; $year++)
                                <option value="{{ $year }}" {{ isset($editFee) && $editFee->year == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <!-- Academic Year Dropdown -->
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="academic_year" class="form-label">Academic Year</label>
                        <select name="academic_year" id="academic_year" class="form-control" required>
                            <option value="" disabled {{ !isset($editFee) ? 'selected' : '' }}>Select Academic Year</option>
                            @for($year = 2020; $year <= 2030; $year++)
                                <option value="{{ $year }}-{{ $year + 1 }}" {{ isset($editFee) && $editFee->academic_year == "$year-".($year+1) ? 'selected' : '' }}>{{ $year }}-{{ $year + 1 }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <!-- Fee Type Inputs -->
                @if(isset($editFee))
                    <div class="row gutters-8">
                        <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                            <label for="fee_type" class="form-label">Fee Type</label>
                            <input type="text" name="fee_type" id="fee_type" class="form-control" value="{{ $editFee->fee_type }}" readonly>
                        </div>
                        <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                            <label for="fee_amount" class="form-label">Fee Amount</label>
                            <input type="number" name="fee_amount" id="fee_amount" class="form-control" value="{{ $editFee->fee_amount }}" step="0.01" min="0" required>
                        </div>
                    </div>
                @else
                    @forelse($feeTypes as $feeType)
                        <div class="row gutters-8">
                            <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                <label for="fee_amount_{{ $feeType->id }}" class="form-label">{{ $feeType->fee_type }}</label>
                                <input type="number" name="fee_amounts[{{ $feeType->id }}]" id="fee_amount_{{ $feeType->id }}" class="form-control" step="0.01" min="0" required>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-warning">No fee types available. Please add fee types first.</div>
                    @endforelse
                @endif
                <!-- Submit Button -->
                <div class="row gutters-8">
                    <div class="col-12 form-group">
                        <button type="submit" class="fw-btn-fill btn-gradient-yellow btn-lg">{{ isset($editFee) ? 'Update Fee' : 'Submit Fee' }}</button>
                        @if(isset($editFee))
                            <a href="{{ route('fee-management') }}" class="btn btn-md btn-secondary ml-2">Cancel</a>
                        @endif
                    </div>
                </div>
            </form>
            <hr class="my-4">
            <!-- Fee List -->
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Fee List</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Fee Type</th>
                            <th>Fee Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fees as $fee)
                            <tr>
                                <td>{{ $fee->class }}</td>
                                <td>{{ $fee->section }}</td>
                                <td>{{ $fee->month }}</td>
                                <td>{{ $fee->year }}</td>
                                <td>{{ $fee->fee_type }}</td>
                                <td>{{ number_format($fee->fee_amount, 2) }}</td>
                                <td>
                                    <a href="{{ route('fee-management.edit', $fee->id) }}" class="btn btn-lg btn-gradient-yellow">
                                        <i class="fas fa-cogs"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No fees added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Fee Management Area End Here -->
</div>
@endsection