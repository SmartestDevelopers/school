@extends('layouts.front')

@section('content')
            <div class="dashboard-content-one">
                <!-- Breadcubs Area Start Here -->
                <div class="breadcrumbs-area">
                    <h3>Classes</h3>
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>All Classes</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Class Table Area Start Here -->
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>All Class Schedules</h3>
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
                        <form class="mg-b-20">
                            <div class="row gutters-8">
                                <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" placeholder="Search by ID ..." class="form-control">
                                </div>
                                <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
                                    <input type="text" placeholder="Search by Name ..." class="form-control">
                                </div>
                                <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" placeholder="Search by Class ..." class="form-control">
                                </div>
                                <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
                                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">SEARCH</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th> 
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input checkAll">
                                                <label class="form-check-label">ID</label>
                                            </div>
                                        </th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Phone</th>
                                        <th>E-mail</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0021</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student2.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>10.00 am - 11.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0022</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student3.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0023</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student4.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0024</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student5.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>12.00 am - 01.30 am </td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0025</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student6.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>10.00 am - 11.30 am </td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0026</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student7.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0027</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student8.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0028</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student9.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0029</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student10.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>12.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0030</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student6.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>10.00 am - 11.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0021</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student2.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0022</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student3.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>10.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0023</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student4.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>09.00 am - 10.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0024</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student5.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0025</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student6.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0026</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student7.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>10.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0027</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student8.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0028</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student9.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0029</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student10.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>10.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0030</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student6.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>10.00 am - 11.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0021</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student2.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>10.00 am - 11.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0022</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student3.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>10.00 am - 11.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0023</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student4.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>10.00 am - 11.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0024</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student5.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>10.00 am - 11.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0025</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student6.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>10.00 am - 11.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0026</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student7.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0027</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student8.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0028</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student9.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0029</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student10.png" alt="student"></td>
                                        <td>Mark Willy</td>
                                        <td>Male</td>
                                        <td>2</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input">
                                                <label class="form-check-label">#0030</label>
                                            </div>
                                        </td>
                                        <td class="text-center"><img src="img/figure/student6.png" alt="student"></td>
                                        <td>Jessia Rose</td>
                                        <td>Female</td>
                                        <td>1</td>
                                        <td>A</td>
                                        <td>02/05/2001</td>
                                        <td>11.00 am - 12.30 am</td>
                                        <td>+ 123 9988568</td>
                                        <td>kazifahim93@gmail.com</td>
                                         <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="flaticon-more-button-of-three-dots"></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#"><i class="fas fa-times text-orange-red"></i>Close</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                                                    <a class="dropdown-item" href="#"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Class Table Area End Here -->
            </div>
        </div>
        <!-- Page Area End Here -->
    </div>
@endsection