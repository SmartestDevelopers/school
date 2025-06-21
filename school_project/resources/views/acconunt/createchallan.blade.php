@extends('layouts.front')

@section('content')
<style>
    .dashboard-content-one {
        padding: 15px;
        max-height: 90vh;
        overflow-y: auto;
    }
    .card {
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    .card-body {
        padding: 15px;
    }
    .form-group {
        margin-bottom: 10px;
        padding: 0 2px;
    }
    .form-label {
        font-weight: 600;
        font-size: 10px;
        margin-bottom: 2px;
        display: block;
        line-height: 1.2;
    }
    .form-control {
        padding: 4px;
        font-size: 10px;
        border-radius: 3px;
        height: 26px;
        width: 100%;
        box-sizing: border-box;
    }
    .btn-gradient-yellow {
        background: linear-gradient(90deg, #ff8c00, #ffa500);
        color: white;
        border: none;
        padding: 6px 12px;
        font-size: 10px;
        border-radius: 3px;
    }
    .btn-gradient-yellow:hover {
        background: linear-gradient(90deg, #e07b00, #ff8c00);
    }
    .alert {
        padding: 8px;
        margin-bottom: 8px;
        border-radius: 3px;
        font-size: 10px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    .table-responsive {
        overflow-x: hidden;
    }
    .table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
        font-size: 10px;
    }
    .table th, .table td {
        padding: 6px;
        text-align: left;
        vertical-align: middle;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    .table td {
        border-top: 1px solid #dee2e6;
    }
    .hidden {
        display: none;
    }
    .error-message {
        color: #721c24;
        font-size: 8px;
        margin-top: 1px;
        line-height: 1.2;
    }
    .form-row {
        display: flex;
        align-items: flex-start;
        flex-wrap: nowrap;
        margin: 0 -2px;
    }
    .form-group.col-md-1, .form-group.col-md-3 {
        flex: 0 0 auto;
        padding: 0 2px;
        box-sizing: border-box;
    }
    .form-group.col-md-1 {
        width: 8.333333%;
    }
    .form-group.col-md-3 {
        width: 25%;
    }
    .form-control, .form-label {
        max-height: 26px;
        overflow: hidden;
    }
    @media (max-width: 768px) {
        .form-row {
            flex-wrap: wrap;
        }
        .form-group.col-md-1, .form-group.col-md-3 {
            flex: 0 0 100%;
            width: 100%;
            padding: 0 5px;
        }
        .form-control, .btn, .form-label, .table th, .table td {
            font-size: 9px;
        }
        .form-control {
            height: 24px;
            padding: 3px;
        }
        .btn {
            padding: 5px 10px;
        }
        .card-body, .dashboard-content-one {
            padding: 10px;
        }
        .error-message {
            font-size: 7px;
        }
    }
</style>

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
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Challan Form -->
        <form action="{{ route('create-challan.store') }}" method="POST" class="mg-b-20">
            @csrf
            <div class="form-row">
                <!-- School Name -->
                <div class="col-md-1 form-group">
                    <label for="school_name" class="form-label">School Name</label>
                    <input type="text" name="school_name" id="school_name" class="form-control" value="FG FPS (2nd Shift) PAF BASE FAISAL KARACHI" required>
                    @error('school_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Academic Year -->
                <div class="col-md-1 form-group">
                    <label for="academic_year" class="form-label">Academic Year</label>
                    <select name="academic_year" id="academic_year" class="form-control" required>
                        <option value="" disabled selected>Select</option>
                        @for($year = 2020; $year <= 2030; $year++)
                            <option value="{{ $year }}-{{ $year + 1 }}">{{ $year }}-{{ $year + 1 }}</option>
                        @endfor
                    </select>
                    @error('academic_year')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Class -->
                <div class="col-md-1 form-group">
                    <label for="class" class="form-label">Class</label>
                    <select name="class" id="class" class="form-control" required onchange="updateStudents()">
                        <option value="" disabled selected>Select</option>
                        @foreach(['ECE', 'Prep', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten'] as $class)
                            <option value="{{ $class }}">{{ $class }}</option>
                        @endforeach
                    </select>
                    @error('class')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Section -->
                <div class="col-md-1 form-group">
                    <label for="section" class="form-label">Section</label>
                    <select name="section" id="section" class="form-control" required onchange="updateStudents()">
                        <option value="" disabled selected>Select</option>
                        @foreach(['A', 'B', 'Pink', 'Green', 'Red', 'Orange', 'Blue', 'Silver', 'Yellow'] as $section)
                            <option value="{{ $section }}">{{ $section }}</option>
                        @endforeach
                    </select>
                    @error('section')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- How Many Months -->
                <div class="col-md-1 form-group">
                    <label for="months_option" class="form-label">Months Option</label>
                    <select name="months_option" id="months_option" class="form-control" required onchange="toggleMonthFields()">
                        <option value="" disabled selected>Select</option>
                        <option value="one">One</option>
                        <option value="many">Many</option>
                    </select>
                    @error('months_option')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- How Many Students -->
                <div class="col-md-1 form-group">
                    <label for="students_option" class="form-label">Students Option</label>
                    <select name="students_option" id="students_option" class="form-control" required onchange="toggleStudentFields()">
                        <option value="" disabled selected>Select</option>
                        <option value="one">One</option>
                        <option value="all">All</option>
                    </select>
                    @error('students_option')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Month (One) -->
                <div class="col-md-1 form-group one-month-field hidden">
                    <label for="month" class="form-label">Month</label>
                    <select name="month" id="month" class="form-control">
                        <option value="" disabled selected>Select</option>
                        @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                            <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                    </select>
                    @error('month')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Year (One) -->
                <div class="col-md-1 form-group one-month-field hidden">
                    <label for="year" class="form-label">Year</label>
                    <select name="year" id="year" class="form-control">
                        <option value="" disabled selected>Select</option>
                        @for($year = 2020; $year <= 2030; $year++)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                    @error('year')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- From Month (Many) -->
                <div class="col-md-1 form-group many-month-field hidden">
                    <label for="from_month" class="form-label">From Month</label>
                    <select name="from_month" id="from_month" class="form-control" onchange="calculateTotalMonths()">
                        <option value="" disabled selected>Select</option>
                        @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                            <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                    </select>
                    @error('from_month')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- From Year (Many) -->
                <div class="col-md-1 form-group many-month-field hidden">
                    <label for="from_year" class="form-label">From Year</label>
                    <select name="from_year" id="from_year" class="form-control" onchange="calculateTotalMonths()">
                        <option value="" disabled selected>Select</option>
                        @for($year = 2020; $year <= 2030; $year++)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                    @error('from_year')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- To Month (Many) -->
                <div class="col-md-1 form-group many-month-field hidden">
                    <label for="to_month" class="form-label">To Month</label>
                    <select name="to_month" id="to_month" class="form-control" onchange="calculateTotalMonths()">
                        <option value="" disabled selected>Select</option>
                        @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                            <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                    </select>
                    @error('to_month')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- To Year (Many) -->
                <div class="col-md-1 form-group many-month-field hidden">
                    <label for="to_year" class="form-label">To Year</label>
                    <select name="to_year" id="to_year" class="form-control" onchange="calculateTotalMonths()">
                        <option value="" disabled selected>Select</option>
                        @for($year = 2020; $year <= 2030; $year++)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                    @error('to_year')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Total Months -->
                <div class="col-md-1 form-group">
                    <label for="total_months" class="form-label">Total Months</label>
                    <input type="number" name="total_months" id="total_months" class="form-control" readonly>
                    @error('total_months')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Student Name -->
                <div class="col-md-3 form-group student-field hidden">
                    <label for="student_id" class="form-label">Student Name</label>
                    <select name="student_id" id="student_id" class="form-control">
                        <option value="" disabled selected>Select Student</option>
                    </select>
                    @error('student_id')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- Create Challan Button -->
            <div class="row gutters-8">
                <div class="col-12 form-group">
                    <button type="submit" class="btn-gradient-yellow">Create Challan</button>
                </div>
            </div>
        </form>
        <hr class="my-4">
        <!-- Challan List -->
        <div class="heading-layout1">
            <div class="item-title">
                <h3>Challan List</h3>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table display data-table">
                <thead>
                    <tr>
                        <th>Academic Year</th>
                        <th>Year</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Student</th>
                        <th>Months</th>
                        <th>Fee</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($challans as $challan)
                        <tr>
                            <td>{{ $challan->academic_year }}</td>
                            <td>{{ $challan->year }}</td>
                            <td>{{ $challan->class }}</td>
                            <td>{{ $challan->section }}</td>
                            <td>{{ $challan->full_name }} ({{ $challan->gr_number }})</td>
                            <td>
                                {{ $challan->to_month ? ($challan->from_month . ' ' . $challan->from_year . ' - ' . $challan->to_month . ' ' . $challan->to_year) : $challan->from_month }}
                            </td>
                            <td>{{ number_format($challan->total_fee, 2) }}</td>
                            <td>{{ $challan->due_date }}</td>
                            <td>{{ ucfirst($challan->status) }}</td>
                            <td>
                                <a href="{{ route('challan-view', $challan->id) }}" class="btn btn-lg btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="{{ route('download-challan', $challan->id) }}" class="btn btn-lg btn-secondary">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No challans created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function toggleMonthFields() {
        const monthsOption = document.getElementById('months_option').value;
        const oneMonthFields = document.querySelectorAll('.one-month-field');
        const manyMonthFields = document.querySelectorAll('.many-month-field');
        const totalMonthsField = document.getElementById('total_months');

        oneMonthFields.forEach(field => field.classList.add('hidden'));
        manyMonthFields.forEach(field => field.classList.add('hidden'));

        if (monthsOption === 'one') {
            oneMonthFields.forEach(field => {
                field.classList.remove('hidden');
                field.querySelector('select').required = true;
            });
            manyMonthFields.forEach(field => {
                field.querySelector('select').required = false;
                field.querySelector('select').value = '';
            });
            totalMonthsField.value = 1;
            totalMonthsField.required = false;
        } else if (monthsOption === 'many') {
            manyMonthFields.forEach(field => {
                field.classList.remove('hidden');
                field.querySelector('select').required = true;
            });
            oneMonthFields.forEach(field => {
                field.querySelector('select').required = false;
                field.querySelector('select').value = '';
            });
            totalMonthsField.value = '';
            totalMonthsField.required = true;
            calculateTotalMonths();
        } else {
            oneMonthFields.forEach(field => {
                field.querySelector('select').required = false;
                field.querySelector('select').value = '';
            });
            manyMonthFields.forEach(field => {
                field.querySelector('select').required = false;
                field.querySelector('select').value = '';
            });
            totalMonthsField.value = '';
            totalMonthsField.required = false;
        }
    }

    function toggleStudentFields() {
        const studentsOption = document.getElementById('students_option').value;
        const studentField = document.querySelector('.student-field');

        studentField.classList.add('hidden');

        if (studentsOption === 'one') {
            studentField.classList.remove('hidden');
            studentField.querySelector('select').required = true;
            updateStudents();
        } else {
            studentField.querySelector('select').required = false;
            studentField.querySelector('select').value = '';
        }
    }

    async function updateStudents() {
        const classSelect = document.getElementById('class').value;
        const sectionSelect = document.getElementById('section').value;
        const studentSelect = document.getElementById('student_id');

        if (classSelect && sectionSelect) {
            try {
                const url = `{{ route('api.students') }}?class=${encodeURIComponent(classSelect)}§ion=${encodeURIComponent(sectionSelect)}`;
                console.log('Fetching students from:', url);
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const students = await response.json();
                console.log('Students fetched:', students);
                studentSelect.innerHTML = '<option value="" disabled selected>Select Student</option>';
                if (students.length === 0) {
                    console.warn('No students found for class:', classSelect, 'section:', sectionSelect);
                }
                students.forEach(student => {
                    const option = document.createElement('option');
                    option.value = student.id;
                    option.text = `${student.name} (Roll: ${student.roll_number})`;
                    studentSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error fetching students:', error);
            }
        } else {
            studentSelect.innerHTML = '<option value="" disabled selected>Select Student</option>';
        }
    }

    function calculateTotalMonths() {
        const fromMonth = document.getElementById('from_month').value;
        const fromYear = parseInt(document.getElementById('from_year').value);
        const toMonth = document.getElementById('to_month').value;
        const toYear = parseInt(document.getElementById('to_year').value);
        const totalMonthsField = document.getElementById('total_months');

        if (fromMonth && fromYear && toMonth && toYear) {
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            const fromMonthIndex = months.indexOf(fromMonth);
            const toMonthIndex = months.indexOf(toMonth);
            const yearDiff = toYear - fromYear;
            let totalMonths = yearDiff * 12 + (toMonthIndex - fromMonthIndex) + 1;
            if (totalMonths < 1) totalMonths = 0;
            totalMonthsField.value = totalMonths;
        } else {
            totalMonthsField.value = '';
        }
    }

    // Initialize form state
    document.addEventListener('DOMContentLoaded', function() {
        toggleMonthFields();
        toggleStudentFields();
    });
</script>
@endsection