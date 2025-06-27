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
    .pagination {
        margin-top: 20px;
        justify-content: center;
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
        .pagination {
            font-size: 12px;
        }
    }
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">REPORTS CLASSWISE FEES</div>
                <div class="card-body">
                    <h4>Classwise Fees List</h4>
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
                                    <th>Serial#</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Total Students</th>
                                    <th>Students' Fee (Expected)</th>
                                    <th>Students' Fee (Debit)(Unpaid)</th>
                                    <th>Students' Fee (Credit)(Paid)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalExpected = 0;
                                    $totalUnpaid = 0;
                                    $totalPaid = 0;
                                @endphp
                                @foreach ($classWiseFees as $index => $feeData)
                                    <tr>
                                        <td>{{ $classWiseFees->firstItem() + $index }}</td>
                                        <td>{{ $feeData->class }}</td>
                                        <td>{{ $feeData->section }}</td>
                                        <td>{{ $feeData->total_students }}</td>
                                        <td>{{ number_format($feeData->expected_fee, 2) }}</td>
                                        <td>{{ number_format($feeData->unpaid_fee, 2) }}</td>
                                        <td>{{ number_format($feeData->paid_fee, 2) }}</td>
                                    </tr>
                                    @php
                                        $totalExpected += $feeData->expected_fee;
                                        $totalUnpaid += $feeData->unpaid_fee;
                                        $totalPaid += $feeData->paid_fee;
                                    @endphp
                                @endforeach
                                <tr class="total-row">
                                    <td colspan="4" class="text-right">Total</td>
                                    <td>{{ number_format($totalExpected, 2) }}</td>
                                    <td>{{ number_format($totalUnpaid, 2) }}</td>
                                    <td>{{ number_format($totalPaid, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="pagination">
                            {{ $classWiseFees->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
