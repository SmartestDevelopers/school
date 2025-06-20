@extends('layouts.front')

@section('content')
<style>
    .dashboard-content-one {
        padding: 15px;
        max-height: 90vh;
        overflow-y: auto;
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
</style>

<div class="dashboard-content-one">
    <h3>View Challan #{{ $challan->id }}</h3>
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <p><strong>School:</strong> {{ $challan->school_name }}</p>
    <p><strong>Student:</strong> {{ $challan->full_name }}</p>
    <p><strong>Father's Name:</strong> {{ $challan->father_name ?? 'N/A' }}</p>
    <p><strong>G.R Number:</strong> {{ $challan->gr_number ?? 'N/A' }}</p>
    <p><strong>Class/Section:</strong> {{ $challan->class }} - {{ $challan->section }}</p>
    <p><strong>Academic Session:</strong> {{ $challan->academic_year }}</p>
    <p><strong>Period:</strong> From {{ $challan->from_month }}-{{ $challan->from_year }} @if($challan->to_month) to {{ $challan->to_month }}-{{ $challan->to_year }} @endif</p>
    <p><strong>Total Fee:</strong> {{ number_format($challan->total_fee, 2) }}</p>
    <p><strong>Status:</strong> {{ ucfirst($challan->status) }}</p>
    <p><strong>Due Date:</strong> {{ $challan->due_date }}</p>
    <p><strong>Amount in Words:</strong> {{ $challan->amount_in_words }}</p>
    <a href="{{ route('download-challan', $challan->id) }}" class="btn btn-primary">Download PDF</a>
    <a href="{{ route('create-challan') }}" class="btn btn-secondary">Back to Challans</a>
</div>
@endsection