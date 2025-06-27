@extends('layouts.front')

@section('content')
<style>
    .container-fluid {
        padding: 20px;
    }
    .card {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .card-header {
        background-color: #007bff;
        color: white;
        font-size: 1.5rem;
        padding: 10px 15px;
    }
    .card-body {
        padding: 15px;
    }
    .table {
        font-size: 14px;
        margin-top: 10px;
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .btn-sm {
        font-size: 12px;
        padding: 4px 8px;
    }
    @media (max-width: 768px) {
        .table {
            font-size: 12px;
        }
        .btn-sm {
            font-size: 10px;
            padding: 3px 6px;
        }
        .card-header {
            font-size: 1.2rem;
        }
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">REPORTS CLASSWISE STUDENTS</div>
                <div class="card-body">
                    <h4>Class List</h4>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($students->isEmpty())
                        <div class="alert alert-info">No students found for this class and section.</div>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial#</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Student</th>
                                    <th>Gender</th>
                                    <th>Roll Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $student->class }}</td>
                                        <td>{{ $student->section }}</td>
                                        <td>{{ $student->full_name }}</td>
                                        <td>{{ ucfirst($student->gender) }}</td>
                                        <td>{{ $student->roll }}</td>
                                        <td>
                                            <form action="{{ route('delete-student', $student->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection