@extends('layouts.front')

@section('content')
    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>View Student</h3>
            <ul>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>Student View</li>
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
                        <h3>View Student</h3>
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
                <form class="new-added-form" method="" action=""
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Full Name *</label>
                            <input type="text" value="{{$getStudentByID->full_name}}"  class="form-control" name="full_name">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Parent Name *</label>
                            <input type="text" value="{{$getStudentByID->parent_name}}" class="form-control" name="parent_name">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Gender *</label>
                            <select class="form-control" name="gender">
                                <option value="{{$getStudentByID->gender}}">{{$getStudentByID->gender}}</option>

                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Date Of Birth *</label>
                            <input type="date" placeholder="dd/mm/yyyy" value="{{$getStudentByID->dob}}" class="form-control air-datepicker"
                                data-position='bottom right' name="dob">
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
                             </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Religion *</label>
                            <select class="form-control" name="religion">
                                <option value="{{$getStudentByID->religion}}">{{$getStudentByID->religion}}</option>

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
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Section *</label>
                            <select class="form-control" name="section">
                                <option value="{{$getStudentByID->section}}">{{$getStudentByID->section}}</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Teacher Name *</label>
                            <input type="text" value="{{$getStudentByID->teacher_name}}" class="form-control" name="teacher_name">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Admission ID</label>
                            <input type="text" name="admission_id" value="{{$getStudentByID->admission_id}}" class="form-control">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Phone</label>
                            <input type="text" value="{{$getStudentByID->phone}}" class="form-control" name="phone">
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




     <div class="dashboard-content-one">
                <!-- Breadcubs Area Start Here -->
                <div class="breadcrumbs-area">
                    <h3>Students</h3>
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>Student Details</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Student Details Area Start Here -->
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Student Details</h3>
                            </div>
                           <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" 
                                data-toggle="dropdown" aria-expanded="false">...</a>
        
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                </div>
                            </div>
                        </div>
                        <div class="single-info-details">
                            <div class="item-img">
                                <img src="img/figure/student1.jpg" alt="student">
                            </div>
                            <div class="item-content">
                                <div class="header-inline item-header">
                                    <h3 class="text-dark-medium font-medium">{{$getStudentByID->full_name}}</h3>
                                    <div class="header-elements">
                                        <ul>
                                            <li><a href="#"><i class="far fa-edit"></i></a></li>
                                            <li><a href="#"><i class="fas fa-print"></i></a></li>
                                            <li><a href="#"><i class="fas fa-download"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="info-table table-responsive">
                                    <table class="table text-nowrap">
                                        <tbody>
                                            <tr>
                                                <td>Name:</td>
                                                <td class="font-medium text-dark-medium">{{$getStudentByID->full_name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Parent Name:</td>
                                                <td class="font-medium text-dark-medium">{{$getStudentByID->parent_name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Gender:</td>
                                                <td class="font-medium text-dark-medium">{{$getStudentByID->gender}}</td>
                                            </tr>>
                                            <tr>
                                                <td>Date Of Birth:</td>
                                                <td class="font-medium text-dark-medium">{{$getStudentByID->dob}}</td>
                                            </tr>
                                            <tr>
                                                <td>Religion:</td>
                                                <td class="font-medium text-dark-medium">{{$getStudentByID->religion}}</td>
                                            </tr>
                                            <tr>
                                                <td>E-mail:</td>
                                                <td class="font-medium text-dark-medium">{{$getStudentByID->email}}</td>
                                            </tr>
                                            <tr>
                                                <td>Blood Group:</td>
                                                <td class="font-medium text-dark-medium">{{$getStudentByID->blood_group}}</td>
                                            </tr>
                                            <tr>
                                                <td>Class:</td>
                                                <td class="font-medium text-dark-medium">{{$getStudentByID->class}}</td>
                                            </tr>
                                            <tr>
                                                <td>Section:</td>
                                                <td class="font-medium text-dark-medium">{{$getStudentByID->section}}</td>
                                            </tr>
                                            <tr>
                                                <td>Teacher Name:</td>
                                                <td class="font-medium text-dark-medium">{{$getStudentByID->teacher_name}}</td>
                                            </tr>
                                            <tr>
                                                <td>Roll:</td>
                                                <td class="font-medium text-dark-medium">{{$getStudentByID->roll}}</td>
                                            </tr></td>
                                            </tr>
                                            <tr>
                                                <td>Address:</td>
                                                <td class="font-medium text-dark-medium">{{$getStudentByID->address}}</td>
                                            </tr></td>
                                            </tr>
                                            <tr>
                                                <td>Phone:</td>
                                                <td class="font-medium text-dark-medium">{{$getStudentByID->address}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Student Details Area End Here -->
            </div>
        </div>
        <!-- Page Area End Here -->
    </div>
@endsection