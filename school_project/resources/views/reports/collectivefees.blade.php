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
    .form-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: nowrap;
    }
    .form-row select, .form-row button {
        height: 38px;
        flex: 1;
        max-width: 150px;
    }
    .btn-sm {
        font-size: 12px;
        padding: 4px 8px;
    }
    .total-column {
        font-weight: bold;
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
                <div class="card-header">REPORTS OVERALL COLLECTIVE FEES CLASSWISE</div>
                <div class="card-body">
                    <form action="{{ route('collective-fees') }}" method="GET" class="form-row">
                        <select name="from_month" class="form-control">
                            <option value="">Select From Month</option>
                            @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                <option value="{{ $month }}" {{ request('from_month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                            @endforeach
                        </select>
                        <select name="from_year" class="form-control">
                            <option value="">Select From Year</option>
                            @for ($year = 2020; $year <= 2025; $year++)
                                <option value="{{ $year }}" {{ request('from_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                        <select name="to_month" class="form-control">
                            <option value="">Select To Month</option>
                            @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                                <option value="{{ $month }}" {{ request('to_month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                            @endforeach
                        </select>
                        <select name="to_year" class="form-control">
                            <option value="">Select To Year</option>
                            @for ($year = 2020; $year <= 2025; $year++)
                                <option value="{{ $year }}" {{ request('to_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (empty($feeTypes) || empty($collectiveFees))
                        <div class="alert alert-info">No fee data available for the selected period.</div>
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
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($collectiveFees as $feeData)
                                    <tr>
                                        <td>{{ $feeData->class }}</td>
                                        <td>{{ $feeData->section }}</td>
                                        <td>{{ $feeData->month }}</td>
                                        <td>{{ $feeData->year }}</td>
                                        @foreach ($feeTypes as $feeType)
                                            <td>{{ number_format($feeData->fee_types[$feeType] ?? 0, 2) }}</td>
                                        @endforeach
                                        <td class="total-column">{{ number_format($feeData->total_fees, 2) }}</td>
                                        <td>
                                            <a href="{{ route('collective-fees-details', ['class' => $feeData->class, 'section' => $feeData->section, 'month' => $feeData->month, 'year' => $feeData->year]) }}" class="btn btn-primary btn-sm">View</a>
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