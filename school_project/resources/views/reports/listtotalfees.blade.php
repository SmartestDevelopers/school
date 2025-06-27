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
                <div class="card-header">Class-Wise Fee Report</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($classWiseFees->isEmpty())
                        <div class="alert alert-info">No fee data available.</div>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Total Students</th>
                                    <th>Expected Fee</th>
                                    <th>Paid Fee</th>
                                    <th>Unpaid Fee</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalStudents = 0;
                                    $totalExpected = 0;
                                    $totalPaid = 0;
                                    $totalUnpaid = 0;
                                @endphp
                                @foreach ($classWiseFees as $fee)
                                    <tr>
                                        <td>{{ $fee->class }}</td>
                                        <td>{{ $fee->section }}</td>
                                        <td>{{ $fee->total_students }}</td>
                                        <td>{{ number_format($fee->expected_fee, 2) }}</td>
                                        <td>{{ number_format($fee->paid_fee, 2) }}</td>
                                        <td>{{ number_format($fee->unpaid_fee, 2) }}</td>
                                    </tr>
                                    @php
                                        $totalStudents += $fee->total_students;
                                        $totalExpected += $fee->expected_fee;
                                        $totalPaid += $fee->paid_fee;
                                        $totalUnpaid += $fee->unpaid_fee;
                                    @endphp
                                @endforeach
                                <tr class="total-row">
                                    <td colspan="2" class="text-right">Total</td>
                                    <td>{{ $totalStudents }}</td>
                                    <td>{{ number_format($totalExpected, 2) }}</td>
                                    <td>{{ number_format($totalPaid, 2) }}</td>
                                    <td>{{ number_format($totalUnpaid, 2) }}</td>
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