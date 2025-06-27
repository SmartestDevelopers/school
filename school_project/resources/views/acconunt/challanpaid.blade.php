@extends('layouts.front')

@section('content')
<style>
    .container-fluid {
        padding: 20px;
    }
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }
    .card-header {
        background: linear-gradient(90deg, #ff8c00, #ffa500);
        color: #fff;
        font-size: 20px;
        font-weight: 600;
        padding: 15px;
        border-radius: 10px 10px 0 0;
    }
    .card-body {
        padding: 20px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-label {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 6px;
        display: block;
        color: #333;
    }
    .form-control {
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 4px;
        border: 1px solid #ced4da;
        height: 38px;
        width: 100%;
    }
    .btn-primary {
        background: linear-gradient(90deg, #ff8c00, #ffa500);
        border: none;
        font-size: 14px;
        padding: 8px 16px;
        border-radius: 4px;
    }
    .btn-primary:hover {
        background: linear-gradient(90deg, #e07b00, #ff8c00);
    }
    .alert {
        padding: 12px;
        margin-bottom: 15px;
        border-radius: 4px;
        font-size: 14px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    .status-label {
        font-weight: bold;
        color: {{ $challan->status == 'paid' ? 'green' : 'red' }};
    }
    @media (max-width: 768px) {
        .form-control, .btn-primary, .form-label {
            font-size: 12px;
        }
        .form-control {
            height: 34px;
            padding: 6px 10px;
        }
        .btn-primary {
            padding: 6px 12px;
        }
        .card-body {
            padding: 15px;
        }
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Mark Challan as Paid (Status: <span class="status-label">{{ strtoupper($challan->status) }}</span>)</div>
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

                    <form action="{{ route('mark-paid', $challan->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="school_name" class="form-label">School Name</label>
                            <input type="text" name="school_name" id="school_name" class="form-control" value="{{ old('school_name', $challan->school_name) }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="academic_year" class="form-label">Academic Year</label>
                            <input type="text" name="academic_year" id="academic_year" class="form-control" value="{{ old('academic_year', $challan->academic_year) }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="class" class="form-label">Class</label>
                            <input type="text" name="class" id="class" class="form-control" value="{{ old('class', $challan->class) }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="section" class="form-label">Section</label>
                            <input type="text" name="section" id="section" class="form-control" value="{{ old('section', $challan->section) }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="month" class="form-label">Month</label>
                            <input type="text" name="month" id="month" class="form-control" value="{{ old('month', $challan->from_month) }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="year" class="form-label">Year</label>
                            <input type="number" name="year" id="year" class="form-control" value="{{ old('year', $challan->from_year) }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="roll" class="form-label">Student Roll</label>
                            <select name="roll" id="roll_number" class="form-control" required>
                                <option value="">Select Student</option>
                                @foreach ($students as $student)
                                    <option value="{{ $student->roll }}" {{ $challan->gr_number == $student->roll ? 'selected' : '' }}>{{ $student->name }} (Roll: {{ $student->roll_number }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Mark as Paid</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection