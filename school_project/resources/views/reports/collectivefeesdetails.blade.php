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
                <div class="card-header">FEE DETAILS FOR CLASS {{ $class }} - SECTION {{ $section }} - {{ $month }} {{ $year }}</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($details->isEmpty())
                        <div class="alert alert-info">No fee details available.</div>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Serial#</th>
                                    <th>Student Name</th>
                                    <th>Roll</th>
                                    @foreach ($feeTypes as $feeType)
                                        <th>{{ $feeType }}</th>
                                    @endforeach
                                    <th>Total Fees</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalFees = 0;
                                @endphp
                                @foreach ($details as $index => $detail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $detail->full_name }}</td>
                                        <td>{{ $detail->roll }}</td>
                                        @foreach ($feeTypes as $feeType)
                                            <td>{{ number_format($detail->fee_types[$feeType] ?? 0, 2) }}</td>
                                        @endforeach
                                        <td>{{ number_format($detail->total_fees, 2) }}</td>
                                        <td>{{ $detail->status }}</td>
                                    </tr>
                                    @php
                                        $totalFees += $detail->total_fees;
                                    @endphp
                                @endforeach
                                <tr class="total-row">
                                    <td colspan="{{ 3 + count($feeTypes) }}" class="text-right">Total</td>
                                    <td>{{ number_format($totalFees, 2) }}</td>
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
