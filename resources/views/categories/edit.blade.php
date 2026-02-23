@php use Illuminate\Support\Facades\Storage; @endphp

@extends("layouts.app")

@section("title", "Edit Category")

@section("content")
<div class="container py-4">
    <div class="row justify-content-start">
        <div class="col-md-8">
            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Category: {{ $category->name }}</h5>
                    <a href="{{ route('categories.index') }}" class="btn btn-light btn-sm">Back to List</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $category->name) }}">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Parent Category --}}
                        <div class="mb-3">
                            <label class="form-label">Parent Category</label>
                            <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                                <option value="">-- None (Root) --</option>
                                @foreach($categories as $parent)
                                    @if($parent->id !== $category->id)
                                        <option value="{{ $parent->id }}"
                                            {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('parent_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description"
                                      rows="3"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Image --}}
                        <div class="mb-3">
                            <label for="image" class="form-label">Category Image</label>

                            <input type="file"
                                   name="image"
                                   id="image"
                                   class="form-control @error('image') is-invalid @enderror"
                                   accept="image/*">

                            <small class="text-muted">Recommended size: 500x500px</small>

                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            {{-- Image Preview --}}
                            <div class="mt-2">
                                <img
                                    src="{{ $category->image && Storage::disk('public')->exists($category->image)
                                            ? Storage::url($category->image)
                                            : asset('images/no_image.png') }}"
                                    alt="Category Image"
                                    width="100"
                                    height="100"
                                    class="border rounded">
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="mb-3 form-check form-switch">
                            <input type="hidden" name="status" value="0">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="status"
                                   id="status"
                                   value="1"
                                   {{ old('status', $category->status) ? 'checked' : '' }}>
                            <label class="form-check-label" for="status">Active Status</label>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">Save Category</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
