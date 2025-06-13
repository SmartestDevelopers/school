@extends('layouts.front')

@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Students</h3>
            <ul>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>Student Admit Form</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Admit Form Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Add New Students</h3>
                    </div>
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-expanded="false">...</a>

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
                @if (session('error'))
                    <div class="alert alert-danger mt-2">
                        {{ session('error') }}
                    </div>
                @endif
                <form class="new-added-form" method="post" action="{{ route('admitform.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>First Name *</label>
                            <input type="text" name="first_name" placeholder="" class="form-control">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Last Name *</label>
                            <input type="text" name="last_name" placeholder="" class="form-control">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Gender *</label>
                            <select class="form-control" name="gender">
                                <option value="">Please Select Gender *</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                                <option value="3">Others</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Date Of Birth *</label>
                            <input type="date" placeholder="dd/mm/yyyy" class="form-control air-datepicker"
                                data-position='bottom right' name="dob">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Roll</label>
                            <input type="text" name="roll" placeholder="" class="form-control">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Blood Group *</label>
                            <select class="form-control form-control" name="blood_group">
                                <option value="">Please Select Group *</option>
                                <option value="1">A+</option>
                                <option value="2">A-</option>
                                <option value="3">B+</option>
                                <option value="4">B-</option>
                                <option value="5">O+</option>
                                <option value="6">O-</option>
                                <option value="7">AB+</option>
                                <option value="8">AB-</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Religion *</label>
                            <select class="form-control" name="religion">
                                <option value="">Please Select Religion *</option>
                                <option value="1">Islam</option>
                                <option value="2">Hindu</option>
                                <option value="3">Christian</option>
                                <option value="4">Buddish</option>
                                <option value="5">Others</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>E-Mail</label>
                            <input type="email" name="email" placeholder="" class="form-control">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Class *</label>
                            <select class="form-control" name="class">
                                <option value="">Please Select Class *</option>
                                <option value="1">ECE</option>
                                <option value="2">Prep</option>
                                <option value="3">One</option>
                                <option value="4">Two</option>
                                <option value="5">Three</option>
                                <option value="6">Four</option>
                                <option value="7">Five</option>
                                <option value="8">Six</option>
                                <option value="9">Seven</option>
                                <option value="10">Eight</option>
                                <option value="11">Nine</option>
                                <option value="12">Ten</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Section *</label>
                            <select class="form-control" name="section">
                                <option value="">Please Select Section *</option>
                                <option value="1">Pink</option>
                                <option value="2">Green</option>
                                <option value="3">Red</option>
                                <option value="4">Orange</option>
                                <option value="5">Blue</option>
                                <option value="6">Silver</option>
                                <option value="7">Yellow</option>
                                
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Admission ID</label>
                            <input type="text" placeholder="" class="form-control" name="admission_id">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Phone</label>
                            <input type="text" placeholder="" class="form-control" name="phone">
                        </div>
                        <div class="col-lg-6 col-12 form-group">
                            <label>Address</label>
                            <textarea class="textarea form-control" id="form-message" cols="10"
                                rows="9" name="address"></textarea>
                        </div>
                        <div class="col-lg-6 col-12 form-group mg-t-30">
                            <label class="text-dark-medium">Upload Student Photo (150px X 150px)</label>
                            <input type="file" class="form-control-file" name="photo">
                        </div>
                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Admit Form Area End Here -->
    </div>
    </div>
    <!-- Page Area End Here -->
    </div>
@endsection