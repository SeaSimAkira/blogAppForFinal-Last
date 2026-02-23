{{-- <div>
    <!-- Nothing worth having comes easy. - Theodore Roosevelt -->

</div> --}}

{{-- @foreach ($categories as $category)
    <ul>
        {{ $loop->iteration }}
        {{ $category->name }}
        {{ $category->slug}}
        {{ $category->description}}
        {{ $category->status }}
    </ul>
@endforeach --}}

@extends("layouts.app")
@section("title", "Categories")
@section("content")
<a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add New Category</a>
    <table class="table table-bordered table-hover">
        <thead>
            <th>លេខរៀង</th>
            <th>ឈ្មោះ</th>
            <th>Parent Category</th>
            <th>បរិយាយ</th>
            <th>រូបភាព</th>
            <th>Status</th>
            <th>សកម្មភាព</th>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$category->name}}</td>
                    <td>{{$category->parent->name ?? 'No Parent'}}</td>
                    <td>{{$category->description}}</td>
                    <td>
                        <img src="{{ $category->image && file_exists(public_path('storage/' . $category->image))
                            ? asset('storage/' . $category->image)
                            : asset('images/no_image.png') }}"
                            alt="{{ $category->name }}"
                            width="50"
                            height="50"/>
                    </td>

                    <td><span class="badge {{$category->status ==1 ? 'bg-primary' : 'bg-danger'}}">
                        {{$category->status ==1 ?'Active' : 'Inactive'}}</span>
                    </td>
                    <td>
                        <a href="{{ route('categories.show', $category->id) }}"
                             class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('categories.edit', $category->id) }}"
                             class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Are you sure you want to delete this category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>

            @empty
                <tr><td><span>មិនមានទិន្នន័យ</span></td></tr>
            @endforelse
        </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{$categories->links()}}

        </div>
        @endsection
