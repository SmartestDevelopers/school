@extends('layouts.front')

@section('content')

    <div class="dashboard-content-one">
        <!-- Breadcubs Area Start Here -->
        <div class="breadcrumbs-area">
            <h3>Students</h3>
            <ul>
                <li>
                    <a href="index.html">Home</a>
                </li>
                <li>Student Admit Form</li>
            </ul>
        </div>
        <!-- Breadcubs Area End Here -->
        <!-- Admit Form Area Start Here -->
        <div class="card height-auto">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        <h3>Add New Students</h3>
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
                <form class="new-added-form" method="post" action="{{ route('admitform.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Full Name *</label>
                            <input type="text" placeholder="" class="form-control" name="full_name">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Parent Name *</label>

                            <div class="form-group">
                            <input type="text" name="parent_name_autocomplete" id="parent_name_autocomplete" class="form-control input-lg" placeholder="Enter Parent Name" />
                            <div id="parentList">
                            </div>
                            @csrf
                        </div>
                            
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Gender *</label>
                            <select class="form-control" name="gender">
                                <option value="">Please Select Gender *</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Date Of Birth *</label>
                            <input type="date" placeholder="dd/mm/yyyy" class="form-control air-datepicker"
                                data-position='bottom right' name="dob">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Roll</label>
                            <input type="text" name="roll" placeholder="" class="form-control">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Blood Group *</label>
                            <select class="form-control form-control" name="blood_group">
                                <option value="">Please Select Group *</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="0+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Religion *</label>
                            <select class="form-control" name="religion">
                                <option value="">Please Select Religion *</option>
                                <option value="Islam">Islam</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Christian">Christian</option>
                                <option value="Buddhist">Buddist</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>E-Mail</label>
                            <input type="email" name="email" placeholder="" class="form-control">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Class *</label>
                            <select class="form-control" name="class">
                                <option value="">Please Select Class *</option>
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
                            <select class="form-control" name="section">
                                <option value="">Please Select Section *</option>
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
                            <label>Teacher Name *</label>
                            

                             <select class="form-control" name="teacher_name">
                                <option value="">Please Select Teacher *</option>
                                
                            @foreach($teachers_array as $teacher)
                                <option value="{{ $teacher->first_name }}">{{ $teacher->first_name }}</option>
                            @endforeach

                            </select>

                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Admission ID</label>
                            <input type="text" placeholder="" class="form-control" name="admission_id">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-12 form-group">
                            <label>Phone</label>
                            <input type="text" placeholder="" class="form-control" name="phone">
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




 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
// jQuery(document).ready(function(){
//     jQuery('#parent_name_autocomplete').keyup(function(){ 
//         alert('line 207');
//     });
//ok now it is ok

 (function($) {
    $(document).ready(function(){
        // Log element existence
        console.log('=== Page Load Debug ===');
        console.log('jQuery version:', $.fn.jquery);
        console.log('parent_name_autocomplete exists:', $('#parent_name_autocomplete').length);
        console.log('parentList exists:', $('#parentList').length);
        console.log('CSRF token exists:', $('input[name="_token"]').length);

        // Keyup handler
        $('#parent_name_autocomplete').on('keyup', function(){
            var query = $(this).val().trim();
            console.log('Keyup triggered, Query:', query);
            if (query !== '') {
                var _token = $('input[name="_token"]').val();
                if (!_token) {
                    console.error('CSRF token missing');
                    $('#parentList').fadeIn().html('<ul class="dropdown-menu"><li>CSRF token error</li></ul>');
                    return;
                }
                console.log('Sending AJAX with token:', _token);
                $.ajax({
                    url: "{{ route('autocomplete.fetch_parent_name') }}",
                    method: "POST",
                    data: { query: query, _token: _token },
                    dataType: 'html',
                    success: function(data) {
                        console.log('AJAX Success, Response:', data);
                        if (data.trim() === '') {
                            console.warn('Empty response received');
                            $('#parentList').fadeIn().html('<ul class="dropdown-menu"><li>No results found</li></ul>');
                        } else {
                            $('#parentList').fadeIn().html(data);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error, xhr.responseText);
                        $('#parentList').fadeIn().html('<ul class="dropdown-menu"><li>Error loading data: ' + status + '</li></ul>');
                    }
                });
            } else {
                console.log('Query empty, hiding parentList');
                $('#parentList').fadeOut();
            }
        });

        // Click handler for <li>
        $('#parentList').on('click', 'li', function(e){
            e.preventDefault();
            var selectedText = $(this).text().trim();
            console.log('Clicked li:', selectedText);
            console.log('parent_name_autocomplete exists at click:', $('#parent_name_autocomplete').length);
            if ($('#parent_name_autocomplete').length) {
                $('#parent_name_autocomplete').val(selectedText);
                console.log('Set parent_name_autocomplete to:', selectedText);
            } else {
                console.error('parent_name_autocomplete input not found');
            }
            $('#parentList').fadeOut();
        });

        // Fallback click handler for <li><a>
        $('#parentList').on('click', 'li a', function(e){
            e.preventDefault();
            var selectedText = $(this).text().trim();
            console.log('Clicked a:', selectedText);
            console.log('parent_name_autocomplete exists at click:', $('#parent_name_autocomplete').length);
            if ($('#parent_name_autocomplete').length) {
                $('#parent_name_autocomplete').val(selectedText);
                console.log('Set parent_name_autocomplete to:', selectedText);
            } else {
                console.error('parent_name_autocomplete input not found');
            }
            $('#parentList').fadeOut();
        });

        // Debug all clicks
        $('#parentList').on('click', function(e){
            console.log('Clicked in parentList, target:', e.target);
        });
    });
})(jQuery);

</script>


@endsection