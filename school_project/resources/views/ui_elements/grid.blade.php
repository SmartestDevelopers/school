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
                        <li>Grid</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Grid Area Start Here -->
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1 mg-b-25">
                            <div class="item-title">
                                <h3>Base on Bootstrap System</h3>
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
                        <div class="row">
                           <div class="col-lg-12">
                               <div class="ui-grid-box">Col-lg-12</div>
                           </div> 
                           <div class="col-lg-6">
                               <div class="ui-grid-box">Col-lg-6</div>
                           </div> 
                           <div class="col-lg-6">
                               <div class="ui-grid-box">Col-lg-6</div>
                           </div> 
                           <div class="col-lg-4">
                               <div class="ui-grid-box">Col-lg-4</div>
                           </div> 
                           <div class="col-lg-4">
                               <div class="ui-grid-box">Col-lg-4</div>
                           </div> 
                           <div class="col-lg-4">
                               <div class="ui-grid-box">Col-lg-4</div>
                           </div> 
                           <div class="col-lg-3">
                               <div class="ui-grid-box">Col-lg-3</div>
                           </div> 
                           <div class="col-lg-3">
                               <div class="ui-grid-box">Col-lg-3</div>
                           </div> 
                           <div class="col-lg-3">
                               <div class="ui-grid-box">Col-lg-3</div>
                           </div> 
                           <div class="col-lg-3">
                               <div class="ui-grid-box">Col-lg-3</div>
                           </div> 
                        </div>
                    </div>
                </div>
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1 mg-b-25">
                            <div class="item-title">
                                <h3>Mobile, Tablet & Destop System</h3>
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
                        <div class="row">
                           <div class="col-lg-6">
                               <div class="ui-grid-box">Col-xs-6</div>
                           </div> 
                           <div class="col-lg-6">
                               <div class="ui-grid-box">Col-xs-6</div>
                           </div> 
                           <div class="col-lg-4">
                               <div class="ui-grid-box">Col-sm-4</div>
                           </div> 
                           <div class="col-lg-4">
                               <div class="ui-grid-box">Col-sm-4</div>
                           </div> 
                           <div class="col-lg-4">
                               <div class="ui-grid-box">Col-sm-4</div>
                           </div> 
                           <div class="col-lg-4">
                               <div class="ui-grid-box">Col-sm-4</div>
                           </div> 
                           <div class="col-lg-3">
                               <div class="ui-grid-box">Col-sm-3</div>
                           </div> 
                           <div class="col-lg-3">
                               <div class="ui-grid-box">Col-sm-3</div>
                           </div> 
                           <div class="col-lg-2">
                               <div class="ui-grid-box">Col-sm-2</div>
                           </div> 
                        </div>
                    </div>
                </div>
                <!-- Grid Area End Here -->
            </div>
        </div>
        <!-- Page Area End Here -->
    </div>
@endsection