@extends('layouts.front')

@section('content')
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
                        <div class="form-group">
                            <label for="school_name">School Name</label>
                            <input type="text" name="school_name" id="school_name" class="form-control" value="{{ old('school_name', 'FG FPS (2nd Shift) PAF BASE FAISAL KARACHI') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="academic_year">Academic Year</label>
                            <select name="academic_year" id="academic_year" class="form-control" required>
                                <option value="">Select Academic Year</option>
                                @for ($year = 2023; $year <= 2026; $year++)
                                    <option value="{{ $year }}-{{ $year + 1 }}" {{ old('academic_year') == "$year-".($year+1) ? 'selected' : '' }}>{{ $year }}-{{ $year + 1 }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="class">Class</label>
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
                        <div class="form-group">
                            <label for="section">Section</label>
                            <select name="section" id="section" class="form-control" required>
                                <option value="">Select Section</option>
                                <option value="A" {{ old('section') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('section') == 'B' ? 'selected' : '' }}>B</option>
                                <option value="C" {{ old('section') == 'C' ? 'selected' : '' }}>C</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Months Option</label><br>
                            <input type="radio" name="months_option" value="one" {{ old('months_option', 'one') == 'one' ? 'checked' : '' }} required> One Month
                            <input type="radio" name="months_option" value="many" {{ old('months_option') == 'many' ? 'checked' : '' }}> Many Months
                        </div>
                        <div id="one_month_fields" style="display: {{ old('months_option', 'one') == 'one' ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label for="month">Month</label>
                                <select name="month" id="month" class="form-control">
                                    <option value="">Select Month</option>
                                    @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $m)
                                        <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="year">Year</label>
                                <input type="number" name="year" id="year" class="form-control" value="{{ old('year', date('Y')) }}" min="2023" max="2030">
                            </div>
                        </div>
                        <div id="many_months_fields" style="display: {{ old('months_option') == 'many' ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label for="from_month">From Month</label>
                                <select name="from_month" id="from_month" class="form-control">
                                    <option value="">Select Month</option>
                                    @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $m)
                                        <option value="{{ $m }}" {{ old('from_month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="from_year">From Year</label>
                                <input type="number" name="from_year" id="from_year" class="form-control" value="{{ old('from_year', date('Y')) }}" min="2023" max="2030">
                            </div>
                            <div class="form-group">
                                <label for="to_month">To Month</label>
                                <select name="to_month" id="to_month" class="form-control">
                                    <option value="">Select Month</option>
                                    @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $m)
                                        <option value="{{ $m }}" {{ old('to_month') == $m ? 'selected' : '' }}>{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="to_year">To Year</label>
                                <input type="number" name="to_year" id="to_year" class="form-control" value="{{ old('to_year', date('Y')) }}" min="2023" max="2030">
                            </div>
                            <div class="form-group">
                                <label for="total_months">Total Months</label>
                                <input type="number" name="total_months" id="total_months" class="form-control" value="{{ old('total_months') }}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Students Option</label><br>
                            <input type="radio" name="students_option" value="one" {{ old('students_option', 'one') == 'one' ? 'checked' : '' }} required> One Student
                            <input type="radio" name="students_option" value="all" {{ old('students_option') == 'all' ? 'checked' : '' }}> All Students
                        </div>
                        <div id="one_student_fields" style="display: {{ old('students_option', 'one') == 'one' ? 'block' : 'none' }};">
                            <div class="form-group">
                                <label for="student_id">Student</label>
                                <select name="student_id" id="student_id" class="form-control">
                                    <option value="">Select Student</option>
                                    <!-- Populated via JavaScript -->
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Challan</button>
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
            $('#one_month_fields').show();
            $('#many_months_fields').hide();
            $('#month, #year').prop('required', true);
            $('#from_month, #from_year, #to_month, #to_year, #total_months').prop('required', false);
        } else {
            $('#one_month_fields').hide();
            $('#many_months_fields').show();
            $('#month, #year').prop('required', false);
            $('#from_month, #from_year, #to_month, #to_year, #total_months').prop('required', true);
        }
    });

    $('input[name="students_option"]').change(function() {
        if ($(this).val() === 'one') {
            $('#one_student_fields').show();
            $('#student_id').prop('required', true);
        } else {
            $('#one_student_fields').hide();
            $('#student_id').prop('required', false);
        }
    });

    $('#class, #section').change(function() {
        var classVal = $('#class').val();
        var sectionVal = $('#section').val();
        if (classVal && sectionVal) {
            $.ajax({
                url: '{{ route("api.students") }}',
                type: 'GET',
                data: { class: classVal, section: sectionVal },
                success: function(data) {
                    $('#student_id').empty().append('<option value="">Select Student</option>');
                    $.each(data, function(index, student) {
                        $('#student_id').append('<option value="' + student.id + '">' + student.name + ' (Roll: ' + student.roll_number + ')</option>');
                    });
                },
                error: function(xhr) {
                    console.log('Error fetching students:', xhr.responseText);
                }
            });
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