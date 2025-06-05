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
                        <li>Tab</li>
                    </ul>
                </div>
                <!-- Breadcubs Area End Here -->
                <!-- Tab Area Start Here -->
                <div class="card ui-tab-card">
                    <div class="card-body">
                        <div class="heading-layout1 mg-b-25">
                            <div class="item-title">
                                <h3>Default Tab</h3>
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
                        <div class="basic-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab" aria-selected="true">Home</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" data-toggle="tab" href="#tab2" role="tab" aria-selected="false">Profile</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" data-toggle="tab" href="#tab3" role="tab" aria-selected="false">Settings</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries,but alsowhen an unknown printer took a galley of type 
                                    and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                    alsowhen an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries, but also</p>
                                </div>
                                <div class="tab-pane fade" id="tab2" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries,but alsowhen an unknown printer took a galley of type 
                                    and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                    alsowhen an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries, but also</p>
                                </div>
                                <div class="tab-pane fade" id="tab3" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries,but alsowhen an unknown printer took a galley of type 
                                    and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                    alsowhen an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries, but also</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card ui-tab-card">
                    <div class="card-body">
                        <div class="heading-layout1 mg-b-25">
                            <div class="item-title">
                                <h3>Custom Tab</h3>
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
                        <div class="custom-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab4" role="tab" aria-selected="true">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab5" role="tab" aria-selected="false">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab6" role="tab" aria-selected="false">Settings</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab4" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries,but alsowhen an unknown printer took a galley of type 
                                    and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                    alsowhen an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries, but also</p>
                                </div>
                                <div class="tab-pane fade" id="tab5" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries,but alsowhen an unknown printer took a galley of type 
                                    and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                    alsowhen an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries, but also</p>
                                </div>
                                <div class="tab-pane fade" id="tab6" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries,but alsowhen an unknown printer took a galley of type 
                                    and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                    alsowhen an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries, but also</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card ui-tab-card">
                    <div class="card-body">
                        <div class="heading-layout1 mg-b-25">
                            <div class="item-title">
                                <h3>Nav Tab</h3>
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
                        <div class="border-nav-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab7" role="tab" aria-selected="true">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab8" role="tab" aria-selected="false">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab9" role="tab" aria-selected="false">Settings</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab7" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries,but alsowhen an unknown printer took a galley of type 
                                    and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                    alsowhen an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries, but also</p>
                                </div>
                                <div class="tab-pane fade" id="tab8" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries,but alsowhen an unknown printer took a galley of type 
                                    and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                    alsowhen an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries, but also</p>
                                </div>
                                <div class="tab-pane fade" id="tab9" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries,but alsowhen an unknown printer took a galley of type 
                                    and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                    alsowhen an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries, but also</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card ui-tab-card">
                    <div class="card-body">
                        <div class="heading-layout1 mg-b-25">
                            <div class="item-title">
                                <h3>Vertical Tab</h3>
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
                        <div class="vertical-tab">
                            <ul class="nav nav-tabs flex-column" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab10" role="tab" aria-selected="true">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab11" role="tab" aria-selected="false">Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab12" role="tab" aria-selected="false">Settings</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab10" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                        It has survived not only five centuries, but alsowhen an unknown printer took a galley of type 
                                        and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                        alsowhen an unknown printer took.When an unknown printer took a galley of type and scrambled 
                                        it to make a type specimen book. It has survived not only five centuries, but alsowhen an 
                                        unknown printer took a galley of type and scrambled it to make a type specimen book. It has 
                                        survived not only five centuries, but alsowhen an unknown printer took.</p>
                                </div>
                                <div class="tab-pane fade" id="tab11" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                        It has survived not only five centuries, but alsowhen an unknown printer took a galley of type 
                                        and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                        alsowhen an unknown printer took.When an unknown printer took a galley of type and scrambled 
                                        it to make a type specimen book. It has survived not only five centuries, but alsowhen an 
                                        unknown printer took a galley of type and scrambled it to make a type specimen book. It 
                                        has survived not only five centuries, but alsowhen an unknown printer took.</p>
                                </div>
                                <div class="tab-pane fade" id="tab12" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                        It has survived not only five centuries, but alsowhen an unknown printer took a galley of type 
                                        and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                        alsowhen an unknown printer took.When an unknown printer took a galley of type and scrambled 
                                        it to make a type specimen book. It has survived not only five centuries, but alsowhen an 
                                        unknown printer took a galley of type and scrambled it to make a type specimen book. It has 
                                        survived not only five centuries, but alsowhen an unknown printer took.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card ui-tab-card">
                    <div class="card-body">
                        <div class="heading-layout1 mg-b-25">
                            <div class="item-title">
                                <h3>Icon Tab</h3>
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
                        <div class="icon-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link border-dark-pastel-green active" data-toggle="tab" href="#tab13" role="tab" aria-selected="true"><i class="fas fa-home text-dark-pastel-green"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link border-dodger-blue" data-toggle="tab" href="#tab14" role="tab" aria-selected="false"><i class="fas fa-user text-dodger-blue"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link border-orange-peel" data-toggle="tab" href="#tab15" role="tab" aria-selected="false"><i class="fas fa-share text-orange-peel"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link border-red" data-toggle="tab" href="#tab16" role="tab" aria-selected="false"><i class="fas fa-exclamation-triangle text-red"></i></a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab13" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries,but alsowhen an unknown printer took a galley of type 
                                    and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                    alsowhen an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries, but also</p>
                                </div>
                                <div class="tab-pane fade" id="tab14" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries,but alsowhen an unknown printer took a galley of type 
                                    and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                    alsowhen an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries, but also</p>
                                </div>
                                <div class="tab-pane fade" id="tab15" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries,but alsowhen an unknown printer took a galley of type 
                                    and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                    alsowhen an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries, but also</p>
                                </div>
                                <div class="tab-pane fade" id="tab16" role="tabpanel">
                                    <p>When an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries,but alsowhen an unknown printer took a galley of type 
                                    and scrambled it to make a type specimen book. It has survived not only five centuries, but 
                                    alsowhen an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                    It has survived not only five centuries, but also</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Tab Area End Here -->
            </div>
        </div>
        <!-- Page Area End Here -->
    </div>
@endsection