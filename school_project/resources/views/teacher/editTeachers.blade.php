@extends('layouts.front')

@section('content')
<div class="dashboard-content-one">
    <!-- Breadcrumbs -->
    <div class="breadcrumbs-area">
        <h3>Teacher</h3>
        <ul>
            <li><a href="{{ route('home') }}">Home</a></li>
            <li>Add New Teacher</li>
        </ul>
    </div>

    <!-- Add New Teacher -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Add New Teacher</h3>
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
                
            <form action="{{ route('updateTeacher') }}" method="POST" enctype="multipart/form-data" class="new-added-form">
                @csrf
                <input type="hidden" name="id" value="{{$getTeacherByID->id}}">
                    <div class="row"></div>
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>First Name *</label>
                        <input type="text" value="{{$getTeacherByID->first_name}}" class="form-control"  name="first_name" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Last Name *</label>
                        <input type="text" value="{{$getTeacherByID->last_name}}" class="form-control" name="last_name" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Gender *</label>
                        <select class="form-control" name="gender" required>
                            <option value="{{$getTeacherByID->gender}}" >{{$getTeacherByID->gender}}</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Date Of Birth *</label>
                        <input type="date" placeholder="dd/mm/yyyy" value="{{$getTeacherByID->dob}}" class="form-control air-datepicker" name="dob">
                        <i class="far fa-calendar-alt"></i>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>ID No</label>
                        <input type="text" value="{{$getTeacherByID->id_no}}" class="form-control" name="id_no">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Blood Group *</label>
                        <select class="form-control" name="blood_group" required>
                            <option value="{{$getTeacherByID->blood_group}}">{{$getTeacherByID->blood_group}}</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Religion *</label>
                        <select class="form-control" name="religion" required>
                            <option value="{{$getTeacherByID->religion}}">{{$getTeacherByID->religion}}</option>
                            <option value="Islam">Islam</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Christian">Christian</option>
                            <option value="Buddhist">Buddhist</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>E-Mail</label>
                        <input type="email" value="{{$getTeacherByID->email}}" class="form-control" name="email">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Class *</label>
                        <select name="class" class="form-control" required>
                            <option value="{{$getTeacherByID->class}}">{{$getTeacherByID->class}}</option>
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
                            <option value="Ten">Ten</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Section *</label>
                        <select name="section" class="form-control" required>
                            <option value="{{$getTeacherByID->section}}">{{$getTeacherByID->section}}</option>
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
                        <label>Address</label>
                        <input type="text" value="{{$getTeacherByID->address}}" name="address" class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Phone</label>
                        <input type="text" value="{{$getTeacherByID->phone}}" class="form-control" name="phone">
                    </div>
                    </div>
                    <div class="col-lg-6 col-12 form-group mg-t-30">
                        <label class="text-dark-medium">Upload Teacher Photo (150px X 150px)</label>
                        <input type="file" name="photo" class="form-control-file">
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
@endsection
