@extends('layouts.front')

@section('content')
<style>
    .dashboard-content-one {
        display: grid;
        grid-template-columns: 1fr 1.2fr; /* Slightly wider Fee List */
        gap: 15px;
        padding: 15px;
        max-height: 90vh;
        overflow: hidden;
    }
    .card {
        height: 100%;
        max-height: 80vh;
        overflow-y: auto;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .fee-form, .fee-list {
        padding: 10px;
    }
    .form-group {
        margin-bottom: 10px;
    }
    .form-label {
        font-weight: 600;
        margin-bottom: 4px;
        display: block;
        font-size: 12px;
    }
    .form-control {
        padding: 6px;
        font-size: 12px;
        border-radius: 4px;
        height: 30px;
    }
    .dynamic-fee-field {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        gap: 6px;
    }
    .fee-types-container {
        max-height: 120px;
        overflow-y: auto;
        padding-right: 8px;
    }
    .remove-fee-btn {
        color: red;
        cursor: pointer;
        font-size: 18px;
        line-height: 1;
    }
    .btn {
        padding: 8px 16px;
        font-size: 12px;
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
        overflow-x: hidden;
    }
    .table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }
    .table th, .table td {
        padding: 8px;
        text-align: left;
        vertical-align: middle;
        font-size: 12px;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .table td {
        border-top: 1px solid #dee2e6;
    }
    .table th:nth-child(1), .table td:nth-child(1) { width: 12%; } /* Class */
    .table th:nth-child(2), .table td:nth-child(2) { width: 12%; } /* Section */
    .table th:nth-child(3), .table td:nth-child(3) { width: 12%; } /* Month */
    .table th:nth-child(4), .table td:nth-child(4) { width: 8%; }  /* Year */
    .table th:nth-child(5), .table td:nth-child(5) { width: 12%; } /* Academic Year */
    .table th:nth-child(6), .table td:nth-child(6) { width: 24%; } /* Fees */
    .table th:nth-child(7), .table td:nth-child(7) { width: 20%; } /* Action */
    .fees-column {
        max-height: 80px;
        overflow-y: auto;
        padding: 4px;
        line-height: 1.3;
    }
    .fees-column ul {
        margin: 0;
        padding-left: 12px;
        list-style-type: disc;
        font-size: 12px;
    }
    .fees-column:hover .fees-tooltip {
        display: block;
    }
    .fees-tooltip {
        display: none;
        position: absolute;
        background-color: #333;
        color: white;
        padding: 6px;
        border-radius: 4px;
        z-index: 1000;
        max-width: 220px;
        white-space: normal;
        top: 100%;
        left: 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        font-size: 12px;
    }
    .pagination {
        margin-top: 10px;
        justify-content: center;
    }
    .alert {
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 4px;
        font-size: 12px;
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
            max-height: none;
        }
        .card {
            max-height: none;
        }
        .table th, .table td {
            font-size: 10px;
            padding: 4px;
        }
        .btn {
            padding: 6px 12px;
            font-size: 10px;
        }
        .form-control {
            font-size: 10px;
            padding: 4px;
            height: 28px;
        }
        .form-label {
            font-size: 10px;
        }
        .fees-column ul {
            font-size: 10px;
        }
        .fees-tooltip {
            font-size: 10px;
        }
    }
</style>

<div class="dashboard-content-one">
    <!-- Add/Edit Fee Form -->
    <div class="fee-form">
        <div class="card">
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
                <form action="{{ isset($editFeeGroup) ? route('fee-management.update', $editFeeGroup->fees->first()->id) : route('fee-management.store') }}" method="POST" class="mg-b-10">
                    @csrf
                    @if(isset($editFeeGroup))
                        <input type="hidden" name="_method" value="POST">
                    @endif
                    <div class="row gutters-8">
                        <!-- Class Dropdown -->
                        <div class="col-6 form-group">
                            <label for="class" class="form-label">Class</label>
                            <select name="class" id="class" class="form-control" required>
                                <option value="" disabled {{ !isset($editFeeGroup) ? 'selected' : '' }}>Select</option>
                                @foreach(['ECE', 'Prep', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten'] as $class)
                                    <option value="{{ $class }}" {{ isset($editFeeGroup) && $editFeeGroup->class == $class ? 'selected' : '' }}>{{ $class }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Section Dropdown -->
                        <div class="col-6 form-group">
                            <label for="section" class="form-label">Section</label>
                            <select name="section" id="section" class="form-control" required>
                                <option value="" disabled {{ !isset($editFeeGroup) ? 'selected' : '' }}>Select</option>
                                @foreach(['Pink', 'Green', 'Red', 'Orange', 'Blue', 'Silver', 'Yellow', 'Lime'] as $section)
                                    <option value="{{ $section }}" {{ isset($editFeeGroup) && $editFeeGroup->section == $section ? 'selected' : '' }}>{{ $section }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Month Dropdown -->
                        <div class="col-6 form-group">
                            <label for="month" class="form-label">Month</label>
                            <select name="month" id="month" class="form-control" required>
                                <option value="" disabled {{ !isset($editFeeGroup) ? 'selected' : '' }}>Select</option>
                                @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                    <option value="{{ $month }}" {{ isset($editFeeGroup) && $editFeeGroup->month == $month ? 'selected' : '' }}>{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Year Dropdown -->
                        <div class="col-6 form-group">
                            <label for="year" class="form-label">Year</label>
                            <select name="year" id="year" class="form-control" required>
                                <option value="" disabled {{ !isset($editFeeGroup) ? 'selected' : '' }}>Select</option>
                                @for($year = 2020; $year <= 2030; $year++)
                                    <option value="{{ $year }}" {{ isset($editFeeGroup) && $editFeeGroup->year == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <!-- Academic Year Dropdown -->
                        <div class="col-12 form-group">
                            <label for="academic_year" class="form-label">Academic Year</label>
                            <select name="academic_year" id="academic_year" class="form-control" required>
                                <option value="" disabled {{ !isset($editFeeGroup) ? 'selected' : '' }}>Select</option>
                                @for($year = 2020; $year <= 2030; $year++)
                                    <option value="{{ $year }}-{{ $year + 1 }}" {{ isset($editFeeGroup) && $editFeeGroup->academic_year == "$year-".($year+1) ? 'selected' : '' }}>{{ $year }}-{{ $year + 1 }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <!-- Dynamic Fee Types -->
                    <div id="fee-types-container" class="fee-types-container">
                        @if(isset($editFeeGroup))
                            @foreach($editFeeGroup->fees as $index => $fee)
                                <div class="dynamic-fee-field row gutters-8">
                                    <div class="col-6 form-group">
                                        <label for="fee_type_{{ $index }}" class="form-label">Fee Type</label>
                                        <select name="fee_types[{{ $index }}][type]" id="fee_type_{{ $index }}" class="form-control" required>
                                            <option value="" disabled>Select</option>
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
                                        <option value="" disabled selected>Select</option>
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
                            <button type="button" class="btn btn-info">Add Fee Type</button>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="row-fluid">
                        <div class="col-12 form-group">
                            <button type="submit" class="btn btn-gradient-yellow">{{ isset($editFeeGroup) ? 'Update' : 'Submit' }}</button>
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
        <div class="card">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Fee List</h3>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table display-data">
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
                                        <ul>
                                            @foreach($group->fees->take(3) as $fee)
                                                <li>{{ $fee->fee_type }}: {{ number_format($fee->fee_amount, 2) }}</li>
                                            @endforeach
                                            @if($group->fees->count() > 3)
                                                <li>...</li>
                                            @endif
                                        </ul>
                                        <strong>Total: {{ number_format($group->fees->sum('fee_amount'), 2) }}</strong>
                                        @if($group->fees->count() > 3)
                                            <span class="fees-tooltip">
                                                {{ $group->fees->map(function($fee) { return "{$fee->fee_type}: {$fee->fee_amount}"; })->join(', ') }}
                                            </span>
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
                    <option value="" disabled selected>Select</option>
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