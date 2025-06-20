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
    }
    .form-label {
        font-weight: 600;
        font-size: 12px;
        margin-bottom: 4px;
        display: block;
    }
    .form-control {
        padding: 6px;
        font-size: 12px;
        border-radius: 4px;
        height: 30px;
    }
    .btn-gradient-yellow {
        background: linear-gradient(90deg, #ff8c00, #ffa500);
        color: white;
        border: none;
        padding: 8px 16px;
        font-size: 12px;
        border-radius: 4px;
    }
    .btn-gradient-yellow:hover {
        background: linear-gradient(90deg, #e07b00, #ff8c00);
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
    .table-responsive {
        overflow-x: hidden;
    }
    .table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
        font-size: 12px;
    }
    .table th, .table td {
        padding: 8px;
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
        font-size: 10px;
        margin-top: 2px;
    }
    @media (max-width: 768px) {
        .form-control, .btn, .form-label, .table th, .table td {
            font-size: 10px;
        }
        .form-control {
            height: 28px;
            padding: 4px;
        }
        .btn {
            padding: 6px 12px;
        }
        .card-body, .dashboard-content-one {
            padding: 10px;
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
            <div class="row gutters-8">
                <!-- School Name -->
                <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                    <label for="school_name" class="form-label">School Name</label>
                    <input type="text" name="school_name" id="school_name" class="form-control" value="FG FPS (2nd Shift) PAF BASE FAISAL KARACHI" required>
                    @error('school_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Class Dropdown -->
                <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
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
                <!-- Section Dropdown -->
                <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                    <label for="section" class="form-label">Section</label>
                    <select name="section" id="section" class="form-control" required onchange="updateStudents()">
                        <option value="" disabled selected>Select</option>
                        @foreach(['Pink', 'Green', 'Red', 'Orange', 'Blue', 'Silver', 'Yellow'] as $section)
                            <option value="{{ $section }}">{{ $section }}</option>
                        @endforeach
                    </select>
                    @error('section')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- How Many Months -->
                <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                    <label for="months_option" class="form-label">How Many Months</label>
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
                <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                    <label for="students_option" class="form-label">How Many Students</label>
                    <select name="students_option" id="students_option" class="form-control" required onchange="toggleStudentFields()">
                        <option value="" disabled selected>Select</option>
                        <option value="one">One</option>
                        <option value="all">All</option>
                    </select>
                    @error('students_option')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <!-- One Month Fields -->
                <div id="one-month-fields" class="hidden col-12 row gutters-8">
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
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
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
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
                </div>
                <!-- Many Months Fields -->
                <div id="many-months-fields" class="hidden col-12 row gutters-8">
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
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
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
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
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
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
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
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
                    <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                        <label for="total_months" class="form-label">Total Months</label>
                        <input type="number" name="total_months" id="total_months" class="form-control" readonly>
                        @error('total_months')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- One Student Field -->
                <div id="one-student-field" class="hidden col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
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
        <!-- Fee List as per Classes -->
        <div class="heading-layout1">
            <div class="item-title">
                <h3>Fee List as per Classes</h3>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table display data-table">
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
                            <td>{{ $challan->academic_year }}</td>
                            <td>{{ $challan->year }}</td>
                            <td>{{ $challan->class }}</td>
                            <td>{{ $challan->section }}</td>
                            <td>{{ number_format($challan->total_fee, 2) }}</td>
                            <td>{{ ucfirst($challan->status) }}</td>
                            <td>
                                <a href="{{ route('challan-view', $challan->id) }}" class="btn btn-lg btn-primary">
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

<script>
    function toggleMonthFields() {
        const monthsOption = document.getElementById('months_option').value;
        const oneMonthFields = document.getElementById('one-month-fields');
        const manyMonthsFields = document.getElementById('many-months-fields');

        oneMonthFields.classList.add('hidden');
        manyMonthsFields.classList.add('hidden');

        if (monthsOption === 'one') {
            oneMonthFields.classList.remove('hidden');
            oneMonthFields.querySelectorAll('select').forEach(field => field.required = true);
            manyMonthsFields.querySelectorAll('select, input').forEach(field => field.required = false);
        } else if (monthsOption === 'many') {
            manyMonthsFields.classList.remove('hidden');
            manyMonthsFields.querySelectorAll('select, input').forEach(field => field.required = true);
            oneMonthFields.querySelectorAll('select').forEach(field => field.required = false);
        }
    }

    function toggleStudentFields() {
        const studentsOption = document.getElementById('students_option').value;
        const oneStudentField = document.getElementById('one-student-field');

        oneStudentField.classList.add('hidden');

        if (studentsOption === 'one') {
            oneStudentField.classList.remove('hidden');
            oneStudentField.querySelector('select').required = true;
            updateStudents();
        } else {
            oneStudentField.querySelector('select').required = false;
        }
    }

    async function updateStudents() {
        const classSelect = document.getElementById('class').value;
        const sectionSelect = document.getElementById('section').value;
        const studentSelect = document.getElementById('student_id');

        if (classSelect && sectionSelect) {
            try {
                const url = `/api/students?class=${encodeURIComponent(classSelect)}&section=${encodeURIComponent(sectionSelect)}`;
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
            console.log('Class or section not selected:', classSelect, sectionSelect);
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
</script>
@endsection