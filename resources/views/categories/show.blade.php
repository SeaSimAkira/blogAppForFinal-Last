@extends("layouts.app")
@section("title", "Category show")
@section("content")
<div class="container py-4">
    <div class="row justify-content-start">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Category Details</h5>
                    <div>
                        <a href="{{ route('categories.index') }}" class="btn btn-light btn-sm">Back to List</a>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Category Image -->
                        <div class="col-md-4 mb-3 text-center">
                        <label class="form-label d-block fw-bold">Category Image</label>

                        <img
                        src="{{ $category->image
                                ? asset('storage/' . $category->image)
                                : asset('images/no_image.png') }}"
                        alt="{{ $category->name }}"
                        class="img-fluid rounded border shadow-sm"
                        style="max-height: 250px; object-fit: cover;">
                    </div>


                        <!-- Category Info -->
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-light" style="width: 35%;">Name</th>
                                    <td>{{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Parent Category</th>
                                    <td>
                                        @if($category->parent)
                                            <span class="badge bg-secondary">{{ $category->parent->name }}</span>
                                        @else
                                            <span class="text-muted">None (Root Category)</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status</th>
                                    <td>
                                        @if($category->status)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Created At</th>
                                    <td>{{ $category->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>


                    <div class="mt-3">
                        <label class="fw-bold">Description:</label>
                        <div class="p-3 bg-light border rounded">
                            {{ $category->description ?: 'No description provided.' }}
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
