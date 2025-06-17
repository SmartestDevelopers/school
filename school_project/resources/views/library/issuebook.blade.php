@extends('layouts.front')

@section('content')
<div class="dashboard-content-one">
    <!-- Breadcrumbs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Library</h3>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li>Issue Book</li>
        </ul>
    </div>
    <!-- Breadcrumbs Area End Here -->
    <!-- Issue Book Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>Issue New Book</h3>
                </div>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">...</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('issue-book') }}"><i class="fas fa-times text-orange-red"></i>Close</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                        <a class="dropdown-item" href="{{ route('issue-book') }}"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                    </div>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form class="new-added-form" action="{{ route('store-issue') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Book *</label>
                        <select name="book_id" class="form-control" required>
                            <option value="" disabled selected>Select Book</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">{{ $book->category }} - {{ $book->genre }} ({{ $book->library_id }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Lender Name *</label>
                        <input type="text" name="lender_name" placeholder="e.g., John Doe" class="form-control" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Lender Designation *</label>
                        <select name="lender_designation" class="form-control" id="lender_designation" required>
                            <option value="" disabled selected>Select Designation</option>
                            <option value="Student">Student</option>
                            <option value="Teacher">Teacher</option>
                            <option value="Admin Staff">Admin Staff</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group student-field" style="display: none;">
                        <label>Class</label>
                        <select name="lender_class" class="form-control">
                            <option value="" disabled selected>Select Class</option>
                            @foreach(['ECE', 'Prep', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten'] as $class)
                                <option value="{{ $class }}">{{ $class }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group student-field" style="display: none;">
                        <label>Section</label>
                        <select name="lender_section" class="form-control">
                            <option value="" disabled selected>Select Section</option>
                            @foreach(['Pink', 'Green', 'Red', 'Orange', 'Blue', 'Silver', 'Yellow'] as $section)
                                <option value="{{ $section }}">{{ $section }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group student-field" style="display: none;">
                        <label>Roll Number</label>
                        <input type="text" name="lender_roll_number" placeholder="e.g., 123" class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Issuance Date *</label>
                        <input type="date" name="issuance_date" class="form-control" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Tentative Return Date *</label>
                        <input type="date" name="tentative_return_date" class="form-control" required>
                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Issue Book</button>
                        <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                    </div>
                </div>
            </form>
            <!-- Issued Books List -->
            <div class="table-responsive mt-4">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Book Name</th>
                            <th>Book ID</th>
                            <th>Lender Name</th>
                            <th>Designation</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Issuance Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($issues as $issue)
                            <tr>
                                <td>{{ $issue->category }} - {{ $issue->genre }}</td>
                                <td>{{ $issue->library_id }}</td>
                                <td>{{ $issue->lender_name }}</td>
                                <td>{{ $issue->lender_designation }}</td>
                                <td>{{ $issue->lender_class ?? '-' }}</td>
                                <td>{{ $issue->lender_section ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('update-issue', $issue->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="date" name="issuance_date" value="{{ $issue->issuance_date }}" class="form-control d-inline-block w-auto" required>
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i></button>
                                    </form>
                                </td>
                                <td>
                                    @if($issue->status == 'issued')
                                        <form action="{{ route('update-issue', $issue->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="date" name="return_date" class="form-control d-inline-block w-auto">
                                            <input type="hidden" name="issuance_date" value="{{ $issue->issuance_date }}">
                                            <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-save"></i></button>
                                        </form>
                                    @else
                                        {{ $issue->return_date ? \Carbon\Carbon::parse($issue->return_date)->format('d-m-Y') : '-' }}
                                    @endif
                                </td>
                                <td>{{ ucfirst($issue->status) }} {{ $issue->return_date ? '(Returned on ' . \Carbon\Carbon::parse($issue->return_date)->format('d-m-Y') . ')' : '' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">No books issued yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Issue Book Area End Here -->
    <footer class="footer-wrap-layout1">
        <div class="copyright">© Copyrights <a href="#">akkhor</a> 2019. All rights reserved. Designed by <a href="#">PsdBosS</a></div>
    </footer>
</div>

@push('scripts')
<script>
    document.getElementById('lender_designation').addEventListener('change', function() {
        const studentFields = document.querySelectorAll('.student-field');
        if (this.value === 'Student') {
            studentFields.forEach(field => field.style.display = 'block');
            studentFields.forEach(field => field.querySelector('input, select').setAttribute('required', 'required'));
        } else {
            studentFields.forEach(field => field.style.display = 'none');
            studentFields.forEach(field => field.querySelector('input, select').removeAttribute('required'));
        }
    });
</script>
@endpush
@endsection