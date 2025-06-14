@extends('layouts.front')

@section('content')
<div class="dashboard-content-one">
    <div class="breadcrumbs-area">
        <h3>Parents</h3>
        <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li>Parent Edit</li>
        </ul>
    </div>

    <div class="card height-auto">
        @php
                //print_r($getParentByID)
            @endphp
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Edit Parents</h3>
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
            <form class="new-added-form" method="POST" action="{{ route('update-parent') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$getParentByID->id}}">
                    <div class="row"></div>
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Full Name *</label>
                        <input type="text" value="{{$getParentByID->full_name}}" class="form-control" name="full_name">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Gender *</label>
                        <select class="form-control" name="gender">
                            <option value="{{$getParentByID->gender}}">{{$getParentByID->gender}}</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Parent Occupation *</label>
                        <input type="text" value="{{$getParentByID->parent_occupation}}" class="form-control"  name="parent_occupation">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Spouse Name*</label>
                        <input type="text" value="{{$getParentByID->spouse_name}}" class="form-control"  name="spouse_name">
                    </div>
                    
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Spouse Occupation *</label>
                        <input type="text" value="{{$getParentByID->spouse_occupation}}" class="form-control"  name="spouse_occupation">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>ID No</label>
                        <input type="text" value="{{$getParentByID->id_no}}" class="form-control" name="id_no">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Blood Group *</label>
                        <select name="blood_group" class="form-control">
                            <option value="{{$getParentByID->blood_group}}">{{$getParentByID->blood_group}}</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Religion *</label>
                        <select name="religion" class="form-control">
                            <option value="{{$getParentByID->religion}}">{{$getParentByID->full_name}}</option>
                            <option value="Islam">Islam</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Christian">Christian</option>
                            <option value="Buddhist">Buddhist</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>E-Mail</label>
                        <input type="email" value="{{$getParentByID->email}}"  class="form-control" name="email">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Address</label>
                        <input type="text" value="{{$getParentByID->address}}" class="form-control"name="address" >
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Phone</label>
                        <input type="text" value="{{$getParentByID->phone}}" class="form-control"name="phone" >
                    </div>
                    <div class="col-lg-6 col-12 form-group mg-t-30">
                        <label class="text-dark-medium">Upload Photo</label>
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
