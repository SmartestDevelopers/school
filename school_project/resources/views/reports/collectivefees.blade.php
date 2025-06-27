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
                <div class="card-header">Collective Fees Report</div>
                <div class="card-body">
                    <form method="GET" action="{{ route('collective-fees') }}">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="from_month">From Month</label>
                                <select name="from_month" id="from_month" class="form-control">
                                    <option value="">Select Month</option>
                                    @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                        <option value="{{ $month }}" {{ request('from_month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="from_year">From Year</label>
                                <input type="number" name="from_year" id="from_year" class="form-control" value="{{ request('from_year') ?: 2025 }}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="to_month">To Month</label>
                                <select name="to_month" id="to_month" class="form-control">
                                    <option value="">Select Month</option>
                                    @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                        <option value="{{ $month }}" {{ request('to_month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="to_year">To Year</label>
                                <input type="number" name="to_year" id="to_year" class="form-control" value="{{ request('to_year') ?: 2025 }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if ($collectiveFees->isEmpty())
                        <div class="alert alert-info">No fee details available.</div>
                    @else
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>Month</th>
                                    <th>Year</th>
                                    @foreach ($feeTypes as $feeType)
                                        <th>{{ $feeType }}</th>
                                    @endforeach
                                    <th>Total Fees</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalFees = 0;
                                @endphp
                                @foreach ($collectiveFees as $item)
                                    <tr>
                                        <td>{{ $item->class }}</td>
                                        <td>{{ $item->section }}</td>
                                        <td>{{ $item->month }}</td>
                                        <td>{{ $item->year }}</td>
                                        @foreach ($feeTypes as $feeType)
                                            <td>{{ number_format($item->fee_types[$feeType] ?? 0, 2) }}</td>
                                        @endforeach
                                        <td>{{ number_format($item->total_fees, 2) }}</td>
                                        <td>
                                            <a href="{{ route('collective-fees-details', [$item->class, $item->section, $item->month, $item->year]) }}" class="btn btn-sm btn-info">View</a>
                                        </td>
                                    </tr>
                                    @php
                                        $totalFees += $item->total_fees;
                                    @endphp
                                @endforeach
                                <tr class="total-row">
                                    <td colspan="{{ 4 + count($feeTypes) }}" class="text-right">Total</td>
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