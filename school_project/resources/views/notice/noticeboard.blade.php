@extends('layouts.front')

@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcrumbs Area Start -->
        <div class="breadcrumbs-area">
            <h3>Notice Board</h3>
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Notice</li>
            </ul>
        </div>
        <!-- Breadcrumbs Area End -->

        <div class="row">
            <!-- Add Notice Area Start -->
            <div class="col-4-xxxl col-12">
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Create A Notice</h3>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                    aria-expanded="false">...</a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                </div>
                            </div>
                        </div>

                        <!-- Success message -->
                        @if (session('success'))
                            <div class="alert alert-success mt-2">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form class="new-added-form" action="{{ route('notice.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Enter notice title">
                                </div>
                                <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                    <label for="details">Details</label>
                                    <input type="text" name="details" id="details" class="form-control"
                                        placeholder="Enter notice details">
                                </div>
                                <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                    <label for="posted_by">Posted By</label>
                                    <input type="text" name="posted_by" id="posted_by" class="form-control"
                                        placeholder="Your name">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="col-12-xxxl col-lg-6 col-12 form-group">
                                    <label for="date">Date</label>
                                    <input type="text" name="date" id="date" class="form-control air-datepicker"
                                        placeholder="Select date">
                                    <i class="far fa-calendar-alt"></i>
                                </div>
                                <div class="col-12 form-group mg-t-8">
                                    <button type="submit"
                                        class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                                    <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Add Notice Area End -->

            <!-- All Notice Area Start -->
            <div class="col-8-xxxl col-12">
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Notice Board</h3>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                    aria-expanded="false">...</a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- All Notice Area End -->
        </div>
    </div>
@endsection