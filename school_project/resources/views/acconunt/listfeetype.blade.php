@extends('layouts.front')

@section('content')
<main id="main" class="main">
    <div class="fluid-container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div style="background: linear-gradient(to right, #E4E5E6, #0072ff); color: #000; font-size: 27px; font-weight: bold; text-align: left;" class="card-header">
                        F E E S &nbsp; T Y P E S
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <hr>
                            <!-- Add/Edit Fee Type Form -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div style="background: linear-gradient(to bottom, #0072ff, #00c6ff);" class="card-header">
                                        <h5 style="color: #fff">{{ isset($editFee) ? 'Edit Fee Type' : 'Add New Fee Type' }}</h5>
                                    </div>
                                    <div style="background-color: #fff;" class="card-body">
                                        @if(session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif
                                        @if(session('error'))
                                            <div class="alert alert-danger">{{ session('error') }}</div>
                                        @endif
                                        <form action="{{ isset($editFee) ? route('addfeetype.update', $editFee->id) : route('addfeetype.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label style="font-weight: bold; color: #000;">Fee Type Name</label>
                                                <input type="text" name="fee_type" class="form-control" value="{{ isset($editFee) ? $editFee->fee_type : '' }}" required>
                                            </div>
                                            <hr>
                                            <button type="submit" class="form-control btn btn-primary">{{ isset($editFee) ? 'Update Fee Type' : 'Add Fee Type' }}</button>
                                            @if(isset($editFee))
                                                <a href="{{ route('addfeetype') }}" class="btn btn-secondary mt-2 w-100">Cancel</a>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <!-- Fee Type List Table -->
                            <div class="col-md-8">
                                <div class="card">
                                    <div style="background: linear-gradient(to bottom, #0072ff, #00c6ff);" class="card-header">
                                        <h5 style="color: #fff">Fee Type List</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="datatable-container">
                                            <!-- Edit Modals -->
                                            @foreach($fees as $fee)
                                                <div class="modal fade" id="editModal{{ $fee->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div style="background: linear-gradient(to bottom, #0072ff, #00c6ff);" class="modal-header">
                                                                <h5 style="font-weight: bold; color: #fff" class="modal-title">Edit Fee Type</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="{{ route('addfeetype.update', $fee->id) }}">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{ $fee->id }}">
                                                                    <div class="form-group">
                                                                        <label style="font-weight: bold; color: #000;">Fee Type</label>
                                                                        <input type="text" class="form-control" name="fee_type" value="{{ $fee->fee_type }}" required>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Edit Fee Type</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            <!-- DataTable -->
                                            <table style="margin-top: 20px;" class="table table-striped table-hover" id="myTable">
                                                <thead>
                                                    <tr>
                                                        <th>Fee Type Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($fees as $fee)
                                                        <tr>
                                                            <td>{{ $fee->fee_type }}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $fee->id }}">Edit</button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="2">No fee types added yet.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
@endsection