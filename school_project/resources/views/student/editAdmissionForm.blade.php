@extends('layouts.front')

@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Edit Student</h3>
            <ul>
                <li>
                    <a href="{{url('/home')}}">Home</a>
                </li>
                <li>Student Edit</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Admit Form Area Start Here -->
        <div class="card height-auto">

            @php
                //print_r($getStudentByID)
            @endphp
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Edit Student</h3>
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
                <form class="new-added-form" method="POST" action="{{url('update-student')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$getStudentByID->id}}">
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Full Name *</label>
                            <input type="text" value="{{$getStudentByID->full_name}}" class="form-control" name="full_name">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Parent Name *</label>
                            <input type="text" value="{{$getStudentByID->parent_name}}" class="form-control" name="parent_name">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Gender *</label>
                            <select class="form-control" name="gender">
                                <option value="">Please Select Gender *</option>
                                <option value="{{$getStudentByID->id}}">Male</option>
                                <option value="{{$getStudentByID->id}}">Female</option>
                                <option value="{{$getStudentByID->id}}">Others</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Date Of Birth *</label>
                            <input type="date" placeholder="dd/mm/yyyy" value="{{$getStudentByID->dob}}"
                                class="form-control air-datepicker" data-position='bottom right' name="dob">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Roll</label>
                            <input type="text" value="{{$getStudentByID->roll}}" class="form-control" name="roll">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Blood Group *</label>
                            <select class="form-control" name="blood_group">
                                <option value="{{$getStudentByID->blood_group}}">Please Select Group *</option>
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
                                <option value="{{$getStudentByID->religion}}">Please Select Religion *</option>
                                <option value="1">Islam</option>
                                <option value="2">Hindu</option>
                                <option value="3">Christian</option>
                                <option value="4">Buddish</option>
                                <option value="5">Others</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>E-Mail</label>
                            <input type="email" value="{{$getStudentByID->email}}" class="form-control" name="email">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Class *</label>
                            <select class="form-control" name="class">
                                <option value="{{$getStudentByID->class}}">Please Select Class *</option>
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
                                <option value="12">Ten</option>>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Section *</label>
                            <select class="form-control" name="section">
                                <option value="{{$getStudentByID->section}}">Please Select Section *</option>
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
                            <label>Teacher Name *</label>
                            <input type="text" value="{{$getStudentByID->teacher_name}}" class="form-control" name="teacher_name">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Admission ID</label>
                            <input type="text" value="{{$getStudentByID->admission_id}}"
                                class="form-control" name="admission_id">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Phone</label>
                            <input type="text" value="{{$getStudentByID->phone}}" class="form-control" name="phone">
                        </div>
                        <div class="col-lg-6 col-12 form-group">
                            <label>Address</label>
                            <textarea class="textarea form-control" value="{{$getStudentByID->address}}" id="form-message" cols="10"
                                rows="9"name="address" ></textarea>
                        </div>
                        <div class="col-lg-6 col-12 form-group mg-t-30">
                            <label class="text-dark-medium">Upload Student Photo (150px X 150px)</label>
                            <input type="file" value="{{$getStudentByID->photo}}" class="form-control-file" name="photo">
                        </div>
                        <div class="col-12 form-group mg-t-8">
                            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Update</button>
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