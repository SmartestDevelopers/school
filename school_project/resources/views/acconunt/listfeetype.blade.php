@extends('layouts.front')

@section('content')
<div class="dashboard-content-one">
    <!-- Breadcrumbs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Fee Types</h3>
        <ul>
            <li>
                <a href="index.html">Home</a>
            </li>
            <li>All Fee Types</li>
        </ul>
    </div>
    <!-- Breadcrumbs Area End Here -->
    <!-- Fee Type Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Add New Fee Type</h3>
                </div>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">...</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                    </div>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('addfeetype.store') }}" method="POST" class="mg-b-20">
                @csrf
                <div class="row gutters-8">
                    <div class="col-4-xxxl col-xl-4 col-lg-4 col-12 form-group">
                        <label for="fee_type" class="form-label">Fee Type</label>
                        <input type="text" name="fee_type" id="fee_type" class="form-control" required>
                    </div>
                    <div class="col-2-xxxl col-xl-2 col-lg-2 col-12 form-group">
                        <button type="submit" class="fw-btn-fill btn-gradient-yellow mt-4">Add Fee</button>
                    </div>
                </div>
            </form>
            <hr class="my-4">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Fee Type List</h3>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fee Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fees as $fee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $fee->fee_type }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No fee types added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Fee Type Area End Here -->
</div>
@endsection