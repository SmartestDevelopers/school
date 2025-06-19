@extends('layouts.front')
@section('content')
    <div class="dashboard-content-one">
        <h3>View Challan #{{ $challan->id }}</h3>
        <p>School: {{ $challan->school_name }}</p>
        <p>Student: {{ $challan->student_name }}</p>
        <p>Total Fee: {{ number_format($challan->total_fee, 2) }}</p>
        <a href="{{ route('download-challan', $challan->id) }}" class="btn btn-primary">Download PDF</a>
    </div>
@endsection