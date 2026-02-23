@extends("layouts.app")

@section("title", "Edit Post")

@section("content")

<a href="{{ route('posts.index') }}" class="btn btn-secondary mb-3">
    Back
</a>

<div class="card">
    <div class="card-body">
        <form action="{{ route('posts.update', $post->id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text"
                       name="title"
                       class="form-control"
                       value="{{ old('title', $post->title) }}">
            </div>

            {{-- Category --}}
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-control">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $post->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Content --}}
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea name="content"
                          rows="5"
                          class="form-control">{{ old('content', $post->content) }}</textarea>
            </div>

            {{-- Image --}}
            <div class="mb-3">
                <label class="form-label">Image</label><br>
                @if ($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}"
                         width="120"
                         class="mb-2">
                @endif
                <input type="file" name="image" class="form-control">
            </div>

            {{-- Status --}}
            <div class="mb-3">
                <label class="form-label">Status</label>
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

            <button type="submit" class="btn btn-warning">
                Update Post
            </button>
        </form>
    </div>
</div>

@endsection
