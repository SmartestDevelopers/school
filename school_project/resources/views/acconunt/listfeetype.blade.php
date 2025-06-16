@extends('layouts.front')

@section('content')
<div class="container"> <h2 class="mb-4">Add New Fee Type</h2>
typescript
Copy
Edit
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('fees.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="fee_type" class="form-label">Fee Type</label>
        <input type="text" name="fee_type" id="fee_type" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Fee</button>
</form>

<hr class="my-4">

<h3>Fee Type List</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Fee Type</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
        @forelse($fees as $fee)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $fee->fee_type }}</td>
            <td>{{ $fee->created_at->format('d-m-Y') }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4">No fee types added yet.</td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection