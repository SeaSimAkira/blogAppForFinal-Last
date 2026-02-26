<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Apply authentication middleware
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function __construct()
    {
        // Everyone (admin, editor, user, viewer) can view posts
        $this->middleware('checkUserRole:admin,editor,user,viewer')
        ->only(['index','show']);
        // Create: admin, editor, user
        $this->middleware('checkUserRole:admin,editor,user')
        ->only(['create','store']);
        // Edit/Update: admin, editor
        $this->middleware('checkUserRole:admin,editor')
        ->only(['edit','update']);
        // Delete: admin only
        $this->middleware('checkUserRole:admin')->only(['destroy']);
        // Trash/Restore/ForceDelete: admin only
        $this->middleware('checkUserRole:admin')
        ->only(['trash','restore','forceDelete']);
        View::share('trashCount', Post::onlyTrashed()->count());
    }


    /**
     * Display a listing of posts
     */
    public function index()
    {
        $posts = Post::with(['category', 'user'])
            ->latest()
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();

        return view('posts.create', compact('categories'));
    }

    /**
     * Store new post
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|in:draft,published,archived',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload image
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'excerpt'     => Str::limit(strip_tags($request->content), 120),
            'content'     => $request->content,
            'image'       => $imagePath,
            'status'      => $request->status,
            'category_id' => $request->category_id,
            'user_id'     => Auth::id(),
        ]);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post created successfully');
    }

    /**
     * Display single post
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show edit form
     */
    public function edit(Post $post)
    {
        $categories = Category::where('status', 1)->get();

        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update post
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'content'     => 'required',
            'category_id' => 'required|exists:categories,id',
            'status'      => 'required|in:draft,published,archived',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = $post->image;

        // Replace image if uploaded
        if ($request->hasFile('image')) {

            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'excerpt'     => Str::limit(strip_tags($request->content), 120),
            'content'     => $request->content,
            'image'       => $imagePath,
            'status'      => $request->status,
            'category_id' => $request->category_id,
        ]);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post updated successfully');
    }

    /**
     * Delete post
     */
    public function destroy(Post $post)
    {
        // Delete image
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted successfully');
    }
}