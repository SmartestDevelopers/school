@extends('layouts.front')

@section('content')
<style>
    .dashboard-content-one {
        padding: 20px;
        min-height: 100vh; /* Full viewport height */
    }
    .container-fluid {
        width: 100%;
        padding: 0 20px;
    }
    .card {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }
    .card-header {
        border-radius: 10px 10px 0 0;
        padding: 15px 20px;
        font-size: 20px;
        font-weight: 600;
        background: linear-gradient(90deg, #ff8c00, #ffa500);
        color: #fff;
    }
    .card-body {
        padding: 20px;
        background: #fff;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-label {
        font-weight: 600;
        font-size: 14px;
        margin-bottom:.connect6px;
        display: block;
        color: #333;
    }
    .form-control {
        padding: 8px;
        font-size: 14px;
        border-radius: 4px;
        border: 1px solid #ced4da;
        height: 36px;
        width: 100%;
    }
    .btn-gradient-yellow {
        background: linear-gradient(90deg, #ff8c00, #ffa500);
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 14px;
        border-radius: 4px;
        width: 100%;
        text-align: center;
    }
    .btn-gradient-yellow:hover {
        background: linear-gradient(90deg, #e07 ultrafast, #ff8c00);
    }
    .btn-primary {
        background: linear-gradient(90deg, #ff8c00, #ffa500);
        border: none;
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 4px;
    }
    .btn-primary:hover {
        background: linear-gradient(90deg, #e07b00, #ff8c00);
    }
    .btn-secondary {
        background: #6c757d;
        color: white;
        border: none;
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 4px;
        width: 100%;
    }
    .btn-secondary:hover {
        background: #5a6268;
    }
    .btn-sm.btn-primary {
        padding: 8px 16px;
        font-size: 12px;
    }
    .alert {
        padding: 12px;
        margin-bottom: 15px;
        border-radius: 4px;
        font-size: 14px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        margin-top: 15px;
    }
    .table th, .table td {
        padding: 10px;
        text-align: left;
        vertical-align: middle;
    }
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }
    .table td {
        border-top: 1px solid #dee2e6;
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .modal-content {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    .modal-header {
        background: linear-gradient(90deg, #ff8c00, #ffa500);
        color: #fff;
        border-radius: 10px 10px 0 0;
        padding: 15px 20px;
    }
    .modal-title {
        font-size: 18px;
        font-weight: 600;
    }
    .modal-body {
        padding: 20px;
    }
    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #dee2e6;
    }
    .btn-close {
        background: transparent;
        color: #fff;
        opacity: 0.8;
    }
    .btn-close:hover {
        opacity: 1;
    }
    hr {
        border-top: 1px solid #dee2e6;
        margin: 15px 0;
    }
    .error-message {
        color: #721c24;
        font-size: 12px;
        margin-top: 4px;
    }
    @media (max-width: 768px) {
        .form-control, .btn, .form-label, .table th, .table td {
            font-size: 12px;
        }
        .form-control {
            height: 32px;
            padding: 6px;
        }
        .btn, .btn-primary, .btn-secondary {
            padding: 8px 16px;
            font-size: 12px;
        }
        .card-body, .dashboard-content-one {
            padding: 15px;
        }
        .modal-title {
            font-size: 16px;
        }
        .modal-body, .modal-footer {
            padding: 15px;
        }
    }
    @media (min-width: 1200px) {
        .card-header {
            font-size: 22px;
        }
        .form-label, .form-control, .btn, .table th, .table td {
            font-size: 16px;
        }
        .form-control {
            height: 40px;
            padding: 10px;
        }
        .btn, .btn-primary, .btn-secondary {
            padding: 12px 24px;
        }
        .table th, .table td {
            padding: 12px;
        }
        .modal-title {
            font-size: 20px;
        }
    }
</style>

<main id="main" class="main">
    <div class="container-fluid dashboard-content-one">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        FEE TYPES
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <hr>
                            <!-- Add/Edit Fee Type Form -->
                            <div class="col-md-4 col-lg-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ isset($editFee) ? 'Edit Fee Type' : 'Add New Fee Type' }}</h5>
                                    </div>
                                    <div class="card-body">
                                        @if(session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif
                                        @if(session('error'))
                                            <div class="alert alert-danger">{{ session('error') }}</div>
                                        @endif
                                        <form action="{{ isset($editFee) ? route('addfeetype.update', $editFee->id) : route('addfeetype.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-label" for="fee-type">Fee Type Name</label>
                                                <input type="text"
                                                       id="fee-type"
                                                       name="fee_type"
                                                       class="form-control"
                                                       value="{{ isset($editFee) ? $editFee->fee_type : '' }}"
                                                       required>
                                                @error('fee_type')
                                                    <div class="error-message">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <hr>
                                            <button type="submit" class="btn-gradient-yellow">{{ isset($editFee) ? 'Update Fee Type' : 'Add Fee Type' }}</button>
                                            @if(isset($editFee))
                                                <a href="{{ route('add-fee-type') }}" class="btn btn-secondary mt-2">Cancel</a>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <!-- Fee Type List Table -->
                            <div class="col-md-8 col-lg-9">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Fee Type List</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="datatable-container">
                                            <!-- Edit Modals -->
                                            @foreach($fees as $fee)
                                                <div class="modal fade" id="editModal{{ $fee->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Fee Type</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST" action="{{ route('addfeetype.update', $fee->id) }}">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{ $fee->id }}">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="fee-type-{{ $fee->id }}">Fee Type</label>
                                                                        <input type="text"
                                                                               id="fee-type-{{ $fee->id }}"
                                                                               class="form-control"
                                                                               name="fee_type"
                                                                               value="{{ $fee->fee_type }}"
                                                                               required>
                                                                        @error('fee_type')
                                                                            <div class="error-message">{{ $message }}</div>
                                                                        @enderror
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
                                            <table class="table table-striped table-hover" id="myTable">
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
                                                                <button type="button"
                                                                        class="btn btn-sm btn-primary edit-btn"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#editModal{{ $fee->id }}">Edit</button>
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
        // Initialize DataTable
        $('#myTable').DataTable();

        // Debug Edit button click
        $(document).on('click', '.edit-btn', function() {
            console.log('Edit button clicked for modal: ' + $(this).data('bs-target'));
        });
    });
</script>
@endsection