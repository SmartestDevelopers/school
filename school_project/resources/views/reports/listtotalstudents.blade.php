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
    .total-row {
        font-weight: bold;
        background-color: #f8f9fa;
    }
    @media (max-width: 768px) {
        .table {
            font-size: 12px;
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
                <div class="card-header">Class-Wise Student Report</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($classWiseStudents->isEmpty())
                        <div class="alert alert-info">No student data available.</div>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Boys</th>
                                    <th>Girls</th>
                                    <th>Total Students</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalBoys = 0;
                                    $totalGirls = 0;
                                    $totalStudents = 0;
                                @endphp
                                @foreach ($classWiseStudents as $class)
                                    <tr>
                                        <td>{{ $class->class }}</td>
                                        <td>{{ $class->section }}</td>
                                        <td>{{ $class->boys }}</td>
                                        <td>{{ $class->girls }}</td>
                                        <td>{{ $class->total_students }}</td>
                                        <td>
                                            <a href="{{ route('class-details', [$class->class, $class->section]) }}" class="btn btn-sm btn-info">View</a>
                                        </td>
                                    </tr>
                                    @php
                                        $totalBoys += $class->boys;
                                        $totalGirls += $class->girls;
                                        $totalStudents += $class->total_students;
                                    @endphp
                                @endforeach
                                <tr class="total-row">
                                    <td colspan="2" class="text-right">Total</td>
                                    <td>{{ $totalBoys }}</td>
                                    <td>{{ $totalGirls }}</td>
                                    <td>{{ $totalStudents }}</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
