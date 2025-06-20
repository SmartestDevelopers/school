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
    .heading-layout1 {
        margin-bottom: 15px;
    }
    .item-title h3 {
        font-size: 20px;
        font-weight: 600;
        color: #333;
    }
    .sub-container {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 15px;
    }
    .sub-container h4 {
        font-size: 16px;
        font-weight: 600;
        color: #444;
        margin-bottom: 10px;
    }
    .table-responsive {
        overflow-x: auto;
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
    .btn-danger {
        padding: 8px 16px;
        font-size: 12px;
        border-radius: 4px;
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
        .table th, .table td {
            font-size: 10px;
            padding: 6px;
        }
        .btn {
            padding: 6px 12px;
            font-size: 10px;
        }
        .card-body, .dashboard-content-one {
            padding: 10px;
        }
        .item-title h3 {
            font-size: 18px;
        }
        .sub-container h4 {
            font-size: 14px;
        }
    }
</style>

<div class="dashboard-content-one">
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>REPORTS CLASSWISE STUDENTS</h3>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="sub-container">
                <h4>Classwise Students' Lists</h4>
                <div class="table-responsive">
                    <table class="table display data-table">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>School</th>
                                <th>Class</th>
                                <th>Section</th>
                                <th>Total Students</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($classWiseStudents as $index => $studentGroup)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $studentGroup->school_name }}</td>
                                    <td>{{ $studentGroup->class }}</td>
                                    <td>{{ $studentGroup->section }}</td>
                                    <td>{{ $studentGroup->total_students }}</td>
                                    <td>
                                        <a href="{{ route('reports.total-students', ['class' => $studentGroup->class, 'section' => $studentGroup->section]) }}"
                                           class="btn btn-lg btn-gradient-yellow">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No student records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($detailedStudents)
                <div class="sub-container">
                    <h4>Detailed Student List ({{ $detailedStudents->first()->class }} - {{ $detailedStudents->first()->section }})</h4>
                    <div class="table-responsive">
                        <table class="table display data-table">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>School</th>
                                    <th>Academic Session</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Student Name</th>
                                    <th>Roll#</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($detailedStudents as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $student->school_name }}</td>
                                        <td>{{ $student->academic_session }}</td>
                                        <td>{{ $student->class }}</td>
                                        <td>{{ $student->section }}</td>
                                        <td>{{ $student->student_name }}</td>
                                        <td>{{ $student->roll }}</td>
                                        <td>
                                            <form action="{{ route('reports.delete-student', $student->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-lg btn-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">No students found for this class and section.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.data-table').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[0, 'asc']],
            language: {
                emptyTable: "No data available in table"
            }
        });
    });
</script>
@endsection