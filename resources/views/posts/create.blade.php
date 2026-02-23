@extends("layouts.app")

@section("title", "Create Post")

@section("content")

<a href="{{ route('posts.index') }}" class="btn btn-secondary mb-3">Back</a>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" class="form-control">
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Content</label>
                <textarea name="content" class="form-control" rows="4">{{ old('content') }}</textarea>
            </div>

            <div class="mb-3">
                <label>Image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <div class="mb-3">
                <select name="status" class="form-control" required>
                    <option value="">-- Select Status --</option>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>
                        Draft
                    </option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                        Published
                    </option>
                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>
                        Archived
                    </option>
                </select>

            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

@endsection
