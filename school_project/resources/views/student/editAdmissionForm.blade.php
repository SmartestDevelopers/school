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
                                <option value="{{$getStudentByID->gender}}">{{$getStudentByID->gender}}</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Others">Others</option>
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
                                <option value="{{$getStudentByID->blood_group}}">{{$getStudentByID->blood_group}}</option>
                                <option value="A+">A+</option>
                                <option value="B+">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O_">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Religion *</label>
                            <select class="form-control" name="religion">
                                <option value="{{$getStudentByID->religion}}">{{$getStudentByID->religion}}</option>
                                <option value="Islam">Islam</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Christian">Christian</option>
                                <option value="Buddhist">Buddist</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>E-Mail</label>
                            <input type="email" value="{{$getStudentByID->email}}" class="form-control" name="email">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Class *</label>
                            <select class="form-control" name="class">
                                <option value="{{$getStudentByID->class}}">{{$getStudentByID->class}}</option>
                                <option value="ECE">ECE</option>
                                <option value="Prep">Prep</option>
                                <option value="One">One</option>
                                <option value="Two">Two</option>
                                <option value="Three">Three</option>
                                <option value="Four">Four</option>
                                <option value="Five">Five</option>
                                <option value="Six">Six</option>
                                <option value="Seven">Seven</option>
                                <option value="Eight">Eight</option>
                                <option value="Nine">Nine</option>
                                <option value="Ten">Ten</option>>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Section *</label>
                            <select class="form-control" name="section">
                                <option value="{{$getStudentByID->section}}">{{$getStudentByID->section}}</option>
                                <option value="Pink">Pink</option>
                                <option value="Green">Green</option>
                                <option value="Red">Red</option>
                                <option value="Orange">Orange</option>
                                <option value="Blue">Blue</option>
                                <option value="Silver">Silver</option>
                                <option value="Yellow">Yellow</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Teacher Name *</label>
                            <input type="text" value="{{$getStudentByID->teacher_name}}" class="form-control" name="teacher_name">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Admission ID</label>
                            <input type="text" value="{{$getStudentByID->admission_id}}
                                class="form-control" >
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