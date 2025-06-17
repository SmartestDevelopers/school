@extends('layouts.front')

@section('content')
<div class="dashboard-content-one">
    <!-- Breadcrumbs Area Start Here -->
    <div class="breadcrumbs-area">
        <h3>Library</h3>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li>Add New Book</li>
        </ul>
    </div>
    <!-- Breadcrumbs Area End Here -->
    <!-- Add New Book Area Start Here -->
    <div class="card height-auto">
        <div class="card-body">
            <div class="heading-layout1">
                <div class="item-title">
                    <h3>{{ isset($book) ? 'Edit Book' : 'Add New Book' }}</h3>
                </div>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">...</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('add-book') }}"><i class="fas fa-times text-orange-red"></i>Close</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-cogs text-dark-pastel-green"></i>Edit</a>
                        <a class="dropdown-item" href="{{ route('add-book') }}"><i class="fas fa-redo-alt text-orange-peel"></i>Refresh</a>
                    </div>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <form class="new-added-form" action="{{ isset($book) ? route('update-book', $book->id) : route('store-book') }}" method="POST">
                @csrf
                @if(isset($book))
                    @method('POST')
                @endif
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Book Name *</label>
                        <input type="text" name="name" placeholder="e.g., To Kill a Mockingbird" class="form-control" value="{{ isset($book) ? $book->name : '' }}" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Author *</label>
                        <input type="text" name="author" placeholder="e.g., Harper Lee" class="form-control" value="{{ isset($book) ? $book->author : '' }}" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Category *</label>
                        <select name="category" class="form-control" required>
                            <option value="" disabled {{ !isset($book) ? 'selected' : '' }}>Select Category</option>
                            <option value="Fiction" {{ isset($book) && $book->category == 'Fiction' ? 'selected' : '' }}>Fiction</option>
                            <option value="Non-Fiction" {{ isset($book) && $book->category == 'Non-Fiction' ? 'selected' : '' }}>Non-Fiction</option>
                            <option value="Reference" {{ isset($book) && $book->category == 'Reference' ? 'selected' : '' }}>Reference</option>
                            <option value="Textbook" {{ isset($book) && $book->category == 'Textbook' ? 'selected' : '' }}>Textbook</option>
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Genre *</label>
                        <input type="text" name="genre" placeholder="e.g., Mystery, Sci-Fi" class="form-control" value="{{ isset($book) ? $book->genre : '' }}" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Publication Year *</label>
                        <input type="number" name="publication_year" placeholder="e.g., 2020" class="form-control" value="{{ isset($book) ? $book->publication_year : '' }}" min="1900" max="{{ date('Y') }}" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Library ID *</label>
                        <input type="text" name="library_id" placeholder="e.g., LIB-001" class="form-control" value="{{ isset($book) ? $book->library_id : '' }}" required>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12 form-group">
                        <label>Date of Entry *</label>
                        <input type="date" name="entry_date" class="form-control" value="{{ isset($book) ? $book->entry_date : '' }}" required>
                    </div>
                    <div class="col-12 form-group mg-t-8">
                        <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">{{ isset($book) ? 'Update' : 'Save' }}</button>
                        <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                    </div>
                </div>
            </form>
            <!-- Books List -->
            <div class="table-responsive mt-4">
                <table class="table display data-table text-nowrap">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Book Name</th>
                            <th>Author</th>
                            <th>Genre</th>
                            <th>Publication Year</th>
                            <th>Library ID</th>
                            <th>Date of Entry</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $b)
                            <tr>
                                <td>{{ $b->category }}</td>
                                <td>{{ $b->name }}</td>
                                <td>{{ $b->author }}</td>
                                <td>{{ $b->genre }}</td>
                                <td>{{ $b->publication_year }}</td>
                                <td>{{ $b->library_id }}</td>
                                <td>{{ \Carbon\Carbon::parse($b->entry_date)->format('d-m-Y') }}</td>
                                <td>{{ $b->is_issued ? 'Issued' : 'Available' }}</td>
                                <td>
                                    <a href="{{ route('edit-book', $b->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="{{ route('delete-book', $b->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">No books added yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Add New Book Area End Here -->
</div>
@endsection