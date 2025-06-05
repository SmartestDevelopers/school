@extends('layouts.front')

@section('content')
            <div class="dashboard-content-one">
                <!-- Breadcubs Area Start Here -->
                <div class="breadcrumbs-area">
                    <h3>UI Elements</h3>
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>UI Elements</li>
                        <li>Notification</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Notify Alart Area Start Here -->
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1 mg-b-25">
                            <div class="item-title">
                                <h3>Default Alert</h3>
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
                        <div class="ui-alart-box">
                            <div class="default-alart">
                                <div class="alert alert-primary" role="alert">
                                    This is a primary alert—check it out!
                                  </div>
                                  <div class="alert alert-success" role="alert">
                                    This is a success alert—check it out!
                                  </div>
                                  <div class="alert alert-danger" role="alert">
                                    This is a danger alert—check it out!
                                  </div>
                                  <div class="alert alert-warning" role="alert">
                                    This is a warning alert—check it out!
                                  </div>
                                  <div class="alert alert-info" role="alert">
                                    This is a info alert—check it out!
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1 mg-b-25">
                            <div class="item-title">
                                <h3>Dismissing Alerts</h3>
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
                        <div class="ui-alart-box">
                            <div class="dismiss-alart">
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    This is a primary alert—check it out!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    This is a success alert—check it out!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    This is a danger alert—check it out!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    This is a warning alert—check it out!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="alert alert-info alert-dismissible fade show" role="alert">
                                    This is a info alert—check it out!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1 mg-b-25">
                            <div class="item-title">
                                <h3>Colored Alerts With Icons</h3>
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
                        <div class="ui-alart-box">
                            <div class="icon-color-alart">
                                <div class="alert icon-alart bg-light-green2" role="alert">
                                    <i class="far fa-hand-point-right bg-light-green3"></i>
                                    Well done! You successfully read this important alert message.
                                </div>
                                <div class="alert icon-alart bg-fb2" role="alert">
                                    <i class="fas fa-exclamation bg-fb3"></i>
                                    Heads up! This alert needs your attention, but it's not super important.
                                </div>
                                <div class="alert icon-alart bg-yellow2" role="alert">
                                    <i class="fas fa-exclamation-triangle bg-yellow3"></i>
                                    Attention! Learning day desirous informed expenses material returned six the.
                                </div>
                                <div class="alert icon-alart bg-pink2" role="alert">
                                    <i class="fas fa-times bg-pink3"></i>
                                    Attention! Learning day desirous informed expenses material returned six the.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Notify Alart Area End Here -->
            </div>
        </div>
        <!-- Page Area End Here -->
    </div>
@endsection