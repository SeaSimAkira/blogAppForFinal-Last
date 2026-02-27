<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{


public function dashboard()
{
    $usersCount = User::count();
    $activeUsers = User::where('is_active', 1)->count();
    $adminCount = User::where('role', 'admin')->count();
    $postsCount = Post::count(); // if you have posts table

    return view('dashboard', compact(
        'usersCount',
        'activeUsers',
        'adminCount',
        'postsCount'
    ));
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
                // INFO BOX DATA
                $totalUsers = User::count();
                $totalPosts = Post::count();
                $publishedPosts = Post::where('status', 'published')->count();
                $draftPosts = Post::where('status', 'draft')->count();
                $activeUsers = User::where(
                    'last_login_at','>=',now()->subMinutes(10)
                )->count();
                // USERS REGISTERED PER MONTH (Chart)
                $usersChart = User::select(
                        DB::raw('MONTH(created_at) as month'),
                        DB::raw('COUNT(*) as total')
                    )
                    ->groupBy('month')
                    ->orderBy('month')
                    ->pluck('total');

                // POSTS PER MONTH (Chart)
                $postsChart = Post::select(
                        DB::raw('MONTH(created_at) as month'),
                        DB::raw('COUNT(*) as total')
                    )
                    ->groupBy('month')
                    ->orderBy('month')
                    ->pluck('total');

                return view('dashboard', compact(
                    'totalUsers',
                    'totalPosts',
                    'publishedPosts',
                    'draftPosts',
                    'usersChart',
                    'postsChart',
                    'activeUsers',
                ));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
