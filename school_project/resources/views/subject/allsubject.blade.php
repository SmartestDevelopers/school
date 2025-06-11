@extends('layouts.front')

@section('content')
    <div class="dashboard-content-one">
        <div class="breadcrumbs-area">
            <h3>All Subjects</h3>
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Subjects</li>
            </ul>
        </div>

        <div class="row">
            <!-- Add Subject Form -->
            <div class="col-4-xxxl col-12">
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>Add New Subject</h3>
                            </div>
                        </div>
                        <!-- Success message -->
                        @if (session('success'))
                            <div class="alert alert-success mt-2">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form class="new-added-form" method="POST" action="{{ route('allsubject.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-12 form-group">
                                    <label>Subject Name *</label>
                                    <input type="text" name="subject_name" class="form-control" required>
                                </div>
                                <div class="col-lg-6 col-12 form-group">
                                    <label>Subject Type *</label>
                                    <select name="subject_type" class="select2" required>
                                        <option value="">Please Select</option>
                                        <option value="Optional">Optional</option>
                                        <option value="Compulsory">Compulsory</option>
                                    </select>
                                </div>
                                <div class="col-lg-6 col-12 form-group">
                                    <label>Select Class *</label>
                                    <select name="class" class="select2" required>
                                        <option value="">Please Select</option>
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
                                <div class="col-lg-6 col-12 form-group">
                                    <label>Select Code *</label>
                                    <select name="code" class="select2" required>
                                        <option value="">Please Select</option>
                                        <option value="00524">00524</option>
                                        <option value="00525">00525</option>
                                        <option value="00526">00526</option>
                                        <option value="00527">00527</option>
                                        <option value="00528">00528</option>
                                    </select>
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

            <!-- Subject Table (Static Example) -->
            <div class="col-8-xxxl col-12">
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>All Subjects</h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Subject Name</th>
                                        <th>Subject Type</th>
                                        <th>Class</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#0021</td>
                                        <td>Accounting</td>
                                        <td>Mathematics</td>
                                        <td>Four</td>
                                        <td>02/05/2001</td>
                                    </tr>
                                    {{-- Later loop subjects from database --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection