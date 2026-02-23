@extends("layouts.app")

@section("title", "Post Detail")

@section("content")

<a href="{{ route('posts.index') }}" class="btn btn-secondary mb-3">
    Back
</a>

<div class="card">
    <div class="card-header">
        <h4><strong>Title :</strong> {{ $post->title }}</h4>
    </div>

    <div class="card-body">
        <p><strong>Category:</strong> {{ $post->category->name ?? 'No Category' }}</p>
        <p><strong>Author:</strong> {{ $post->user->name ?? 'Guest' }}</p>

        <p>
            <strong>Status:</strong>
            <span class="badge
                {{ $post->status == 'published' ? 'bg-primary'
                : ($post->status == 'draft' ? 'bg-warning' : 'bg-secondary') }}">
                {{ ucfirst($post->status) }}
            </span>
        </p>

        @if ($post->image)
            <img src="{{ asset('storage/' . $post->image) }}"
                 class="img-fluid mb-3"
                 style="max-width: 300px;">
        @endif

        <hr>

        <p><strong>Content :</strong>{!! nl2br(e($post->content)) !!}</p>
    </div>
</div>

@endsection
