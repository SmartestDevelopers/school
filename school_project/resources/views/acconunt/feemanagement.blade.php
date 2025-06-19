@extends('layouts.front')

@section('content')
<style>
    .dashboard-content-one {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        padding: 30px;
    }
    .card {
        height: auto;
        overflow-y: auto;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .fee-form, .fee-list {
        padding: 20px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
    }
    .form-control {
        padding: 10px;
        font-size: 16px;
        border-radius: 4px;
    }
    .dynamic-fee-field {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        gap: 10px;
    }
    .remove-fee-btn {
        color: red;
        cursor: pointer;
        font-size: 24px;
        line-height: 1;
    }
    .btn {
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 4px;
        transition: background-color 0.2s;
    }
    .btn-gradient-yellow {
        background: linear-gradient(90deg, #ff8c00, #ffa500);
        color: white;
        border: none;
    }
    .btn-gradient-yellow:hover {
        background: linear-gradient(90deg, #e07b00, #ff8c00);
    }
    .btn-info {
        background-color: #17a2b8;
        color: white;
        border: none;
    }
    .btn-info:hover {
        background-color: #138496;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
        border: none;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
    }
    .table-responsive {
        overflow-x: auto;
    }
    .table {
        width: 100%;
        table-layout: auto;
        border-collapse: collapse;
    }
    .table th, .table td {
        padding: 12px;
        text-align: left;
        vertical-align: middle;
        white-space: nowrap;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .table td {
        border-top: 1px solid #dee2e6;
    }
    .fees-column {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        position: relative;
    }
    .fees-column:hover .fees-tooltip {
        display: block;
    }
    .fees-tooltip {
        display: none;
        position: absolute;
        background-color: #333;
        color: white;
        padding: 10px;
        border-radius: 4px;
        z-index: 1000;
        max-width: 300px;
        white-space: normal;
        top: 100%;
        left: 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    .pagination {
        margin-top: 20px;
        justify-content: center;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    @media (max-width: 768px) {
        .dashboard-content-one {
            grid-template-columns: 1fr;
        }
        .table th, .table td {
            font-size: 14px;
            padding: 8px;
        }
        .btn {
            padding: 10px 20px;
            font-size: 14px;
        }
    }
</style>

<div class="dashboard-content-one">
    <!-- Add/Edit Fee Form -->
    <div class="fee-form">
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>{{ isset($editFeeGroup) ? 'Edit Fee Group' : 'Add New Fee' }}</h3>
                    </div>
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">...</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('fee-management') }}"><i class="fas fa-times text-orange-red"></i>Close</a>
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
                <form action="{{ isset($editFeeGroup) ? route('fee-management.update', $editFeeGroup->fees->first()->id) : route('fee-management.store') }}" method="POST" class="mg-b-20">
                    @csrf
                    @if(isset($editFeeGroup))
                        <input type="hidden" name="_method" value="POST">
                    @endif
                    <div class="row gutters-8">
                        <!-- Class Dropdown -->
                        <div class="col-6 form-group">
                            <label for="class" class="form-label">Class</label>
                            <select name="class" id="class" class="form-control" required>
                                <option value="" disabled {{ !isset($editFeeGroup) ? 'selected' : '' }}>Select Class</option>
                                @foreach(['ECE', 'Prep', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten'] as $class)
                                    <option value="{{ $class }}" {{ isset($editFeeGroup) && $editFeeGroup->class == $class ? 'selected' : '' }}>{{ $class }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Section Dropdown -->
                        <div class="col-6 form-group">
                            <label for="section" class="form-label">Section</label>
                            <select name="section" id="section" class="form-control" required>
                                <option value="" disabled {{ !isset($editFeeGroup) ? 'selected' : '' }}>Select Section</option>
                                @foreach(['Pink', 'Green', 'Red', 'Orange', 'Blue', 'Silver', 'Yellow', 'Lime'] as $section)
                                    <option value="{{ $section }}" {{ isset($editFeeGroup) && $editFeeGroup->section == $section ? 'selected' : '' }}>{{ $section }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Month Dropdown -->
                        <div class="col-6 form-group">
                            <label for="month" class="form-label">Month</label>
                            <select name="month" id="month" class="form-control" required>
                                <option value="" disabled {{ !isset($editFeeGroup) ? 'selected' : '' }}>Select Month</option>
                                @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                    <option value="{{ $month }}" {{ isset($editFeeGroup) && $editFeeGroup->month == $month ? 'selected' : '' }}>{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Year Dropdown -->
                        <div class="col-6 form-group">
                            <label for="year" class="form-label">Year</label>
                            <select name="year" id="year" class="form-control" required>
                                <option value="" disabled {{ !isset($editFeeGroup) ? 'selected' : '' }}>Select Year</option>
                                @for($year = 2020; $year <= 2030; $year++)
                                    <option value="{{ $year }}" {{ isset($editFeeGroup) && $editFeeGroup->year == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <!-- Academic Year Dropdown -->
                        <div class="col-12 form-group">
                            <label for="academic_year" class="form-label">Academic Year</label>
                            <select name="academic_year" id="academic_year" class="form-control" required>
                                <option value="" disabled {{ !isset($editFeeGroup) ? 'selected' : '' }}>Select Academic Year</option>
                                @for($year = 2020; $year <= 2030; $year++)
                                    <option value="{{ $year }}-{{ $year + 1 }}" {{ isset($editFeeGroup) && $editFeeGroup->academic_year == "$year-".($year+1) ? 'selected' : '' }}>{{ $year }}-{{ $year + 1 }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <!-- Dynamic Fee Types -->
                    <div id="fee-types-container">
                        @if(isset($editFeeGroup))
                            @foreach($editFeeGroup->fees as $index => $fee)
                                <div class="dynamic-fee-field row gutters-8">
                                    <div class="col-6 form-group">
                                        <label for="fee_type_{{ $index }}" class="form-label">Fee Type</label>
                                        <select name="fee_types[{{ $index }}][type]" id="fee_type_{{ $index }}" class="form-control" required>
                                            <option value="" disabled>Select Fee Type</option>
                                            @foreach($feeTypes as $type)
                                                <option value="{{ $type->fee_type }}" {{ $fee->fee_type == $type->fee_type ? 'selected' : '' }}>{{ $type->fee_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-5 form-group">
                                        <label for="fee_amount_{{ $index }}" class="form-label">Amount</label>
                                        <input type="number" name="fee_types[{{ $index }}][amount]" id="fee_amount_{{ $index }}" class="form-control" value="{{ $fee->fee_amount }}" step="0.01" min="0" required>
                                    </div>
                                    <div class="col-1 form-group">
                                        <span class="remove-fee-btn" onclick="removeFeeField(this)">×</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="dynamic-fee-field row gutters-8">
                                <div class="col-6 form-group">
                                    <label for="fee_type_0" class="form-label">Fee Type</label>
                                    <select name="fee_types[0][type]" id="fee_type_0" class="form-control" required>
                                        <option value="" disabled selected>Select Fee Type</option>
                                        @foreach($feeTypes as $type)
                                            <option value="{{ $type->fee_type }}">{{ $type->fee_type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-5 form-group">
                                    <label for="fee_amount_0" class="form-label">Amount</label>
                                    <input type="number" name="fee_types[0][amount]" id="fee_amount_0" class="form-control" step="0.01" min="0" required>
                                </div>
                                <div class="col-1 form-group">
                                    <span class="remove-fee-btn" onclick="removeFeeField(this)">×</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row-fluid">
                        <div class="col-12 form-group">
                            <button type="button" class="btn btn-info" onclick="addFeeField()">Add Another Fee Type</button>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="row-fluid">
                        <div class="col-12 form-group">
                            <button type="submit" class="btn btn-gradient-yellow">{{ isset($editFeeGroup) ? 'Update Fee' : 'Submit Fee' }}</button>
                            @if(isset($editFeeGroup))
                                <a href="{{ route('fee-management') }}" class="btn btn-secondary ml-2">Cancel</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Fee List -->
    <div class="fee-list">
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Fee List</h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table display-data text-nowrap">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Academic Year</th>
                                <th>Fees</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($feeGroups as $group)
                                <tr>
                                    <td>{{ $group->class }}</td>
                                    <td>{{ $group->section }}</td>
                                    <td>{{ $group->month }}</td>
                                    <td>{{ $group->year }}</td>
                                    <td>{{ $group->academic_year }}</td>
                                    <td class="fees-column">
                                        @php
                                            $feeDetails = $group->fees->map(function($fee) {
                                                return "{$fee->fee_type}: {$fee->fee_amount}";
                                            })->take(2)->join(', ');
                                            $total = $group->fees->sum('fee_amount');
                                            $fullDetails = $group->fees->map(function($fee) {
                                                return "{$fee->fee_type}: {$fee->fee_amount}";
                                            })->join(', ');
                                        @endphp
                                        {{ $group->fees->count() > 2 ? $feeDetails . '...' : $feeDetails }}
                                        <br><strong>Total: {{ number_format($total, 2) }}</strong>
                                        @if($group->fees->count() > 2)
                                            <span class="fees-tooltip">{{ $fullDetails }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('fee-management.edit', $group->fees->first()->id) }}" class="btn btn-gradient-yellow">
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
                    <!-- Pagination Links -->
                    <div class="pagination">
                        {{ $feeGroups->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let feeIndex = {{ isset($editFeeGroup) ? count($editFeeGroup->fees) : 1 }};

    function addFeeField() {
        const container = document.getElementById('fee-types-container');
        const newField = document.createElement('div');
        newField.className = 'dynamic-fee-field row gutters-8';
        newField.innerHTML = `
            <div class="col-6 form-group">
                <label for="fee_type_${feeIndex}" class="form-label">Fee Type</label>
                <select name="fee_types[${feeIndex}][type]" id="fee_type_${feeIndex}" class="form-control" required>
                    <option value="" disabled selected>Select Fee Type</option>
                    @foreach($feeTypes as $type)
                        <option value="{{ $type->fee_type }}">{{ $type->fee_type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-5 form-group">
                <label for="fee_amount_${feeIndex}" class="form-label">Amount</label>
                <input type="number" name="fee_types[${feeIndex}][amount]" id="fee_amount_${feeIndex}" class="form-control" step="0.01" min="0" required>
            </div>
            <div class="col-1 form-group">
                <span class="remove-fee-btn" onclick="removeFeeField(this)">×</span>
            </div>
        `;
        container.appendChild(newField);
        feeIndex++;
    }

    function removeFeeField(element) {
        if (document.querySelectorAll('.dynamic-fee-field').length > 1) {
            element.closest('.dynamic-fee-field').remove();
        } else {
            alert('At least one fee type is required.');
        }
    }
</script>
@endsection