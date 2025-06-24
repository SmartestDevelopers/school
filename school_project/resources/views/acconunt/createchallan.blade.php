@extends('layouts.front')

@section('content')
<style>
    .form-group {
        margin-bottom: 0;
        padding: 0 8px;
    }
    .form-control {
        font-size: 14px;
        height: 38px;
        padding: 6px 12px;
    }
    .form-label {
        font-size: 14px;
        margin-bottom: 4px;
        white-space: nowrap;
    }
    .radio-group {
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }
    .radio-group label {
        margin-bottom: 4px;
        font-size: 14px;
    }
    .btn-primary {
        font-size: 14px;
        padding: 8px 16px;
        margin-top: 20px;
    }
    @media (max-width: 768px) {
        .form-group {
            margin-bottom: 10px;
        }
        .form-control, .form-label, .radio-group label {
            font-size: 12px;
        }
        .form-control {
            height: 34px;
            padding: 6px 10px;
        }
        .btn-primary {
            font-size: 12px;
            padding: 6px 12px;
        }
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Create Fee Challan</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('create-challan.store') }}" method="POST">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-3 form-group">
                                <label for="school_name" class="form-label">School Name</label>
                                <input type="text" name="school_name" id="school_name" class="form-control" value="{{ old('school_name', 'FG FPS (2nd Shift) PAF BASE FAISAL KARACHI') }}" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="academic_year" class="form-label">Academic Year</label>
                                <select name="academic_year" id="academic_year" class="form-control" required>
                                    <option value="">Select Year</option>
                                    @for ($year = 2023; $year <= 2026; $year++)
                                        <option value="{{ $year }}-{{ $year + 1 }}" {{ old('academic_year') == "$year-".($year+1) ? 'selected' : '' }}>{{ $year }}-{{ $year + 1 }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="class" class="form-label">Class</label>
                                <select name="class" id="class" class="form-control" required>
                                    <option value="">Select Class</option>
                                    <option value="One" {{ old('class') == 'One' ? 'selected' : '' }}>One</option>
                                    <option value="Two" {{ old('class') == 'Two' ? 'selected' : '' }}>Two</option>
                                    <option value="Three" {{ old('class') == 'Three' ? 'selected' : '' }}>Three</option>
                                    <option value="Four" {{ old('class') == 'Four' ? 'selected' : '' }}>Four</option>
                                    <option value="Five" {{ old('class') == 'Five' ? 'selected' : '' }}>Five</option>
                                    <option value="Six" {{ old('class') == 'Six' ? 'selected' : '' }}>Six</option>
                                    <option value="Seven" {{ old('class') == 'Seven' ? 'selected' : '' }}>Seven</option>
                                    <option value="Eight" {{ old('class') == 'Eight' ? 'selected' : '' }}>Eight</option>
                                    <option value="Nine" {{ old('class') == 'Nine' ? 'selected' : '' }}>Nine</option>
                                    <option value="Ten" {{ old('class') == 'Ten' ? 'selected' : '' }}>Ten</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="section" class="form-label">Section</label>
                                <select name="section" id="section" class="form-control" required>
                                    <option value="">Select Section</option>
                                    <option value="A" {{ old('section') == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('section') == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="C" {{ old('section') == 'C' ? 'selected' : '' }}>C</option>
                                    <option value="Pink" {{ old('section') == 'Pink' ? 'selected' : '' }}>Pink</option>
                                    <option value="Green" {{ old('section') == 'Green' ? 'selected' : '' }}>Green</option>
                                    <option value="Red" {{ old('section') == 'Red' ? 'selected' : '' }}>Red</option>
                                    <option value="Orange" {{ old('section') == 'Orange' ? 'selected' : '' }}>Orange</option>
                                    <option value="Blue" {{ old('section') == 'Blue' ? 'selected' : '' }}>Blue</option>
                                    <option value="Silver" {{ old('section') == 'Silver' ? 'selected' : '' }}>Silver</option>
                                    <option value="Yellow" {{ old('section') == 'Yellow' ? 'selected' : '' }}>Yellow</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="form-label">Months Option</label>
                                <div class="radio-group">
                                    <label><input type="radio" name="months_option" value="one" {{ old('months_option', 'one') == 'one' ? 'checked' : '' }} required> One</label>
                                    <label><input type="radio" name="months_option" value="many" {{ old('months_option') == 'many' ? 'checked' : '' }}> Many</label>
                                </div>
                            </div>
                            <div class="col-md-3 form-group" id="one_month_fields" style="display: {{ old('months_option', 'one') == 'one' ? 'block' : 'none' }};">
                                <label for="month" class="form-label">Month</label>
                                <select name="month" id="month" class="form-control">
                                    <option value="">Select Month</option>
                                    @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $m)
                                        <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group" id="one_month_year" style="display: {{ old('months_option', 'one') == 'one' ? 'block' : 'none' }};">
                                <label for="year" class="form-label">Year</label>
                                <input type="number" name="year" id="year" class="form-control" value="{{ old('year', date('Y')) }}" min="2023" max="2030">
                            </div>
                            <div class="col-md-3 form-group" id="many_months_from" style="display: {{ old('months_option', 'many') == 'many' ? 'block' : 'none' }};">
                                <label for="from_month" class="form-label">From Month</label>
                                <select name="from_month" id="from_month" class="form-control">
                                    <option value="">Select Month</option>
                                    @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $m)
                                        <option value="{{ $m }}" {{ old('from_month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group" id="many_months_from_year" style="display: {{ old('months_option', 'many') == 'many' ? 'block' : 'none' }};">
                                <label for="from_year" class="form-label">From Year</label>
                                <input type="number" name="from_year" id="from_year" class="form-control" value="{{ old('from_year', date('Y')) }}" min="2023" max="2030">
                            </div>
                            <div class="col-md-3 form-group" id="many_months_to" style="display: {{ old('months_option', 'many') == 'many' ? 'block' : 'none' }};">
                                <label for="to_month" class="form-label">To Month</label>
                                <select name="to_month" id="to_month" class="form-control">
                                    <option value="">Select Month</option>
                                    @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $m)
                                        <option value="{{ $m }}" {{ old('to_month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group" id="many_months_to_year" style="display: {{ old('months_option', 'many') == 'many' ? 'block' : 'none' }};">
                                <label for="to_year" class="form-label">To Year</label>
                                <input type="number" name="to_year" id="to_year" class="form-control" value="{{ old('to_year', date('Y')) }}" min="2023" max="2030">
                            </div>
                            <div class="col-md-3 form-group" id="many_months_total" style="display: {{ old('months_option', 'many') == 'many' ? 'block' : 'none' }};">
                                <label for="total_months" class="form-label">Total Months</label>
                                <input type="number" name="total_months" id="total_months" class="form-control" value="{{ old('total_months') }}" readonly>
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="form-label">Students Option</label>
                                <div class="radio-group">
                                    <label><input type="radio" name="students_option" value="one" {{ old('students_option', 'one') == 'one' ? 'checked' : '' }} required> One</label>
                                    <label><input type="radio" name="students_option" value="all" {{ old('students_option') == 'all' ? 'checked' : '' }}> All</label>
                                </div>
                            </div>
                            <div class="col-md-2 form-group" id="one_student_fields" style="display: {{ old('students_option', 'one') == 'one' ? 'block' : 'none' }};">
                                <label for="roll" class="form-label">Student Roll</label>
                                <select name="roll" id="roll_number" class="form-control">
                                    <option value="">Select Student</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->roll_number }}" {{ old('roll') == $student->roll ? 'selected' : '' }} data-class="{{ $student->class }}" data-section="{{ $student->section }}">{{ $student->name }} (Roll: {{ $student->roll_number }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="issue_date" class="form-label">Issue Date</label>
                                <input type="date" name="issue_date" id="issue_date" class="form-control" value="{{ old('issue_date', now()->format('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date', now()->addDays(30)->format('Y-m-d')) }}" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="account_number" class="form-label">Account Number</label>
                                <input type="text" name="account_number" id="account_number" class="form-control" value="{{ old('account_number', '1234567890') }}" required>
                            </div>
                            <div class="col-md-3 form-group">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>

                    <hr>
                    <h4>Existing Challans</h4>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>School Name</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Student Name</th>
                                <th>Period</th>
                                <th>Total Fee</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($challans as $challan)
                                <tr>
                                    <td>{{ $challan->id }}</td>
                                    <td>{{ $challan->school_name }}</td>
                                    <td>{{ $challan->class }}</td>
                                    <td>{{ $challan->section }}</td>
                                    <td>{{ $challan->full_name }}</td>
                                    <td>
                                        {{ $challan->from_month }}-{{ $challan->from_year }}
                                        @if($challan->to_month && $challan->to_year)
                                            to {{ $challan->to_month }}-{{ $challan->to_year }}
                                        @endif
                                    </td>
                                    <td>{{ $challan->total_fee }}</td>
                                    <td>{{ strtoupper($challan->status) }}</td>
                                    <td>
                                        <a href="{{ route('challan-view', $challan->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('download-challan', $challan->id) }}" class="btn btn-success btn-sm">Download</a>
                                        <a href="{{ route('challan-paid', $challan->id) }}" class="btn btn-warning btn-sm">Mark Paid</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('input[name="months_option"]').change(function() {
        if ($(this).val() === 'one') {
            $('#one_month_fields, #one_month_year').show();
            $('#many_months_from, #many_months_from_year, #many_months_to, #many_months_to_year, #many_months_total').hide();
            $('#month, #year').prop('required', true);
            $('#from_month, #from_year, #to_month, #to_year, #total_months').prop('required', false);
        } else {
            $('#one_month_fields, #one_month_year').hide();
            $('#many_months_from, #many_months_from_year, #many_months_to, #many_months_to_year, #many_months_total').show();
            $('#month, #year').prop('required', false);
            $('#from_month, #from_year, #to_month, #to_year, #total_months').prop('required', true);
        }
    });

    $('input[name="students_option"]').change(function() {
        if ($(this).val() === 'one') {
            $('#one_student_fields').show();
            $('#roll_number').prop('required', true);
        } else {
            $('#one_student_fields').hide();
            $('#roll_number').prop('required', false);
        }
    });

    $('#class, #section').change(function() {
        var classVal = $('#class').val();
        var sectionVal = $('#section').val();
        if (classVal && sectionVal) {
            $('#roll_number option').each(function() {
                var option = $(this);
                if (option.val() === '') {
                    option.show();
                } else {
                    var optionClass = option.data('class');
                    var optionSection = option.data('section');
                    if (optionClass === classVal && optionSection === sectionVal) {
                        option.show();
                    } else {
                        option.hide();
                    }
                }
            });
        } else {
            $('#roll_number option').show();
        }
    });

    function calculateTotalMonths() {
        var fromMonth = $('#from_month').val();
        var fromYear = parseInt($('#from_year').val());
        var toMonth = $('#to_month').val();
        var toYear = parseInt($('#to_year').val());

        if (fromMonth && fromYear && toMonth && toYear) {
            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            var fromIndex = months.indexOf(fromMonth);
            var toIndex = months.indexOf(toMonth);
            var totalMonths = (toYear - fromYear) * 12 + (toIndex - fromIndex) + 1;
            $('#total_months').val(totalMonths > 0 ? totalMonths : '');
        }
    }

    $('#from_month, #from_year, #to_month, #to_year').change(calculateTotalMonths);
});
</script>
@endsection