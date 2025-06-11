@extends('layouts.front')

@section('content')
<div class="dashboard-content-one">
    <!-- Breadcrumbs Area Start -->
    <div class="breadcrumbs-area">
        <h3>Transport</h3>
        <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li>Transport</li>
        </ul>
    </div>
    <!-- Breadcrumbs Area End -->

    <div class="row">
        <!-- Add Transport Area Start -->
        <div class="col-12 col-xxxl-4">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>Add New Transport</h3>
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

                    <!-- Success message -->
                @if (session('success'))
                    <div class="alert alert-success mt-2">
                        {{ session('success') }}
                    </div>
                @endif
                
                    <form class="new-added-form" action="{{ route('transport.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-xl-4 col-sm-6 form-group">
                                <label>Route Name</label>
                                <input type="text" name="route_name" class="form-control" required>
                            </div>
                            <div class="col-12 col-xl-4 col-sm-6 form-group">
                                <label>Vehicle Number</label>
                                <input type="text" name="vehicle_no" class="form-control" required>
                            </div>
                            <div class="col-12 col-xl-4 col-sm-6 form-group">
                                <label>Driver Name</label>
                                <input type="text" name="driver_name" class="form-control" required>
                            </div>
                            <div class="col-12 col-xl-4 col-sm-6 form-group">
                                <label>License Number</label>
                                <input type="text" name="license_no" class="form-control" required>
                            </div>
                            <div class="col-12 col-xl-4 col-sm-6 form-group">
                                <label>Phone Number</label>
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                            <div class="col-12 form-group mg-t-8">
                                <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                                <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- Add Transport Area End -->

        <!-- All Transport List Area Start -->
        <div class="col-12 col-xxxl-8">
            <div class="card height-auto">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>All Transport Lists</h3>
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

                    <form class="mg-b-20">
                        <div class="row gutters-8">
                            <div class="col-lg-4 col-12 form-group">
                                <input type="text" placeholder="Search by Route ..." class="form-control">
                            </div>
                            <div class="col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Search by Car Number ..." class="form-control">
                            </div>
                            <div class="col-lg-3 col-12 form-group">
                                <input type="text" placeholder="Search by Phone ..." class="form-control">
                            </div>
                            <div class="col-lg-2 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input checkAll">
                                            <label class="form-check-label">Route Name</label>
                                        </div>
                                    </th>
                                    <th>Vehicle No</th>
                                    <th>Driver Name</th>
                                    <th>Driver License</th>
                                    <th>Contact Number</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input">
                                            <label class="form-check-label">Wales Road</label>
                                        </div>
                                    </td>
                                    <td>MT988800</td>
                                    <td>Johnathan John</td>
                                    <td>DLNC025936</td>
                                    <td>+889562365846</td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                <span class="flaticon-more-button-of-three-dots"></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <!-- All Transport List Area End -->
    </div>
</div>
@endsection
