@extends('layouts.front')

@section('content')
            <div class="dashboard-content-one">
                <!-- Breadcubs Area Start Here -->
                <div class="breadcrumbs-area">
                    <h3>Teacher</h3>
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>Teacher Details</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Student Table Area Start Here -->
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>About Me</h3>
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
                                <img src="img/figure/teacher.jpg" alt="teacher">
                            </div>
                            <div class="item-content">
                                <div class="header-inline item-header">
                                    <h3 class="text-dark-medium font-medium">Steven Johnson</h3>
                                    <div class="header-elements">
                                        <ul>
                                            <li><a href="#"><i class="far fa-edit"></i></a></li>
                                            <li><a href="#"><i class="fas fa-print"></i></a></li>
                                            <li><a href="#"><i class="fas fa-download"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <p>Aliquam erat volutpat. Curabiene natis massa sedde lacu stiquen sodale 
                                word moun taiery.Aliquam erat volutpaturabiene natis massa sedde  sodale 
                                word moun taiery.</p>
                                <div class="info-table table-responsive">
                                    <table class="table text-nowrap">
                                        <tbody>
                                            <tr>
                                                <td>Name:</td>
                                                <td class="font-medium text-dark-medium">Steven Johnson</td>
                                            </tr>
                                            <tr>
                                                <td>Gender:</td>
                                                <td class="font-medium text-dark-medium">Male</td>
                                            </tr>
                                            <tr>
                                                <td>Father Name:</td>
                                                <td class="font-medium text-dark-medium">Steve Jones</td>
                                            </tr>
                                            <tr>
                                                <td>Mother Name:</td>
                                                <td class="font-medium text-dark-medium">Naomi Rose</td>
                                            </tr>
                                            <tr>
                                                <td>Religion:</td>
                                                <td class="font-medium text-dark-medium">Islam</td>
                                            </tr>
                                            <tr>
                                                <td>Joining Date:</td>
                                                <td class="font-medium text-dark-medium">07.08.2016</td>
                                            </tr>
                                            <tr>
                                                <td>E-mail:</td>
                                                <td class="font-medium text-dark-medium">stevenjohnson@gmail.com</td>
                                            </tr>
                                            <tr>
                                                <td>Subject:</td>
                                                <td class="font-medium text-dark-medium">English</td>
                                            </tr>
                                            <tr>
                                                <td>Class:</td>
                                                <td class="font-medium text-dark-medium">2</td>
                                            </tr>
                                            <tr>
                                                <td>Section:</td>
                                                <td class="font-medium text-dark-medium">Pink</td>
                                            </tr>
                                            <tr>
                                                <td>ID No:</td>
                                                <td class="font-medium text-dark-medium">10005</td>
                                            </tr>
                                            <tr>
                                                <td>Address:</td>
                                                <td class="font-medium text-dark-medium">House #10, Road #6, Australia</td>
                                            </tr>
                                            <tr>
                                                <td>Phone:</td>
                                                <td class="font-medium text-dark-medium">+ 88 98568888418</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Student Table Area End Here -->
            </div>
        </div>
        <!-- Page Area End Here -->
    </div>
@endsection