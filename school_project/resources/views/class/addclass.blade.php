@extends('layouts.front')

@section('content')
<div class="dashboard-content-one">
    <!-- Breadcrumbs Area -->
    <div class="breadcrumbs-area">
        <h3>Classes</h3>
        <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li>Add New Class</li>
        </ul>
    </div>

    <!-- Add Class Area -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Add New Class Schedule</h3>
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

            <form class="new-added-form" method="POST" action="{{ route('class.store') }}">
                @csrf
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Teacher Name *</label>
                        <input type="text" name="teacher_name" class="form-control">
                    </div>

                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>ID No</label>
                        <input type="text" name="id_no" class="form-control">
                    </div>

                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Gender *</label>
                        <select name="gender" class="select2">
                            <option value="">Please Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Class *</label>
                        <select name="class" class="select2">
                            <option value="">Please Select</option>
                            <option value="Play">Play</option>
                            <option value="Nursery">Nursery</option>
                            <option value="One">One</option>
                            <option value="Two">Two</option>
                            <option value="Three">Three</option>
                            <option value="Four">Four</option>
                            <option value="Five">Five</option>
                        </select>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Subject *</label>
                        <select name="subject" class="select2">
                            <option value="">Please Select</option>
                            <option value="English">English</option>
                            <option value="Mathematics">Mathematics</option>
                            <option value="Physics">Physics</option>
                            <option value="Chemistry">Chemistry</option>
                            <option value="Biology">Biology</option>
                            <option value="Health & Bio Sceinces">Health & Bio Sciences</option>
                            <option value="Computer Entrepreneurship">Computer Entrepreneurship</option>
                            <option value="Computer Tech">Computer Tech</option>
                            <option value="Urdu">Urdu</option>
                            <option value="Islamiyat">Islamiyat</option>
                            <option value="Ethics for non-Muslims">Ethics for Non-Muslims</option>
                            <option value="Pakistam Studies">Pakistan Studies</option>
                            <option value="Translation of Holy Quran">Translation of Holy Quran</option>
                            <option value="General Science">General Science</option>
                            <option value="Health & Physical Education">Health & Physical Education</option>

                        </select>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Section *</label>
                        <select name="section" class="select2">
                            <option value="">Please Select</option>
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
                        <label>Time *</label>
                        <input type="text" name="time" class="form-control">
                    </div>

                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Date *</label>
                        <input type="text" name="date" placeholder="dd/mm/yyyy" class="form-control air-datepicker" data-position="bottom right">
                        <i class="far fa-calendar-alt"></i>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Phone *</label>
                        <input type="text" name="phone" class="form-control">
                    </div>

                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>E-Mail *</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="col-md-6 form-group"></div>

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
